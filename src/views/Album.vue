<template>
    <div>
        <h1>My Art Gallery</h1>
        <p>This is where I post all my drawings and doodles. Stay tuned!</p>
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
                .get('http://localhost:8080/backend/api/image-posts/all.php')
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
                    'http://localhost:8080/backend/api/auth/checkadmin.php',
                    { params: { password: password } },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
                .then(response => {
                    this.admin = response.data.admin;
                })
        }
    }
}
</script>