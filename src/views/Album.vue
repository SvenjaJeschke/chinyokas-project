<template>
    <div>
        <h1>My Art Gallery</h1>
        <b-progress v-if="imagePostsAreLoading" type="is-success"></b-progress>
        <div v-if="admin" style="display: flex">
            <div style="flex-grow: 1; display: inline-block"></div>
            <b-button 
                type="is-success" 
                style="color: black; margin: 5px; display: inline-block" 
                tag="router-link" 
                to="/create-image-post"
            >
                <b-icon pack="fas" icon="plus" style="margin-right: 3px"></b-icon>
                Create new image post
            </b-button>
        </div>
            <div 
                class="card image-post" 
                v-for="imagePost in imagePosts" 
                :key="imagePost.id" 
            >
                <div class="card-image">
                    <figure class="image is-4by3">
                        <div>
                            <img :src="imagePost.image" :alt="imagePost.title">
                        </div>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="card-header" style="display: flex">
                        <p class="card-header-title" style="color: #e3e3e3">
                            {{imagePost.title}}
                        </p>
                        <div style="flex-grow: 1; display: inline-block"></div>
                        <span style="padding: 10px">
                            {{ $date(imagePost.created_at).format('DD/MM/YYYY HH:mm') }}
                        </span>
                        <b-button 
                            v-if="admin"
                            outlined 
                            type="is-white"
                            tag="router-link"
                            :to="'/edit-image-post/' + parseInt(imagePost.id)"
                        >
                            <b-icon 
                                pack="fas" 
                                icon="pen"
                            ></b-icon>
                        </b-button>
                        <b-button 
                            v-if="admin" 
                            type="is-danger"
                            style="margin-left: 5px"
                            @click="confirmDelete(imagePost.id)"
                        >
                            <b-icon 
                                pack="fas" 
                                icon="trash"
                            ></b-icon>
                        </b-button>
                    </div>
                    <div class="content">
                        {{ imagePost.description }}
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            imagePosts: [],
            imagePostsAreLoading: false,
            admin: false
        }
    },
    watch: {
        admin() {
            this.checkAdmin();
        }
    },
    created() {
        this.checkAdmin();
        this.getImagePosts();
    },
    methods: {
        getImagePosts() {
            this.imagePostsAreLoading = true;
            this.axios
                .get('/backend/api/image-posts/all.php')
                .then(response => {
                    this.imagePosts = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.imagePostsAreLoading = false;
                })
        },
        checkAdmin() {
            const password = localStorage.getItem('password');
            this.axios
                .get(
                    '/backend/api/auth/checkadmin.php',
                    { params: { password: password } },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
                .then(response => {
                    this.admin = response.data.admin;
                })
        },
        confirmDelete(id) {
            this.$buefy.dialog.confirm({
                title: 'Delete image post',
                message: '<p style="color: black">Are you sure you want to <b>delete</b> this image post?</p>',
                confirmText: 'Delete post',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteImagePost(id)
            })
        },
        deleteImagePost(id) {
            this.axios
                .post(
                    '/backend/api/image-posts/delete.php',
                    { id: id },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getImagePosts();
                })
        }
    }
}
</script>

<style scoped>
    img {
        max-width:100%;
        max-height:100%;
        object-fit: contain;
    }
    .image-post {
        width: 49%;
        display: inline-block; 
        margin: 5px;
        padding: 10px; 
        background-color: #212121; 
        color: #e3e3e3;
    }
</style>