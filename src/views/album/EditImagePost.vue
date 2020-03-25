<template>
    <div>
        <h1>Edit Image Post</h1>
        <b-field label="Title">
            <b-input 
                v-model="post.title"
                :loading="isLoading" 
                :disabled="isLoading"
            ></b-input>
        </b-field>
        <b-field label="Description">
            <textarea-autosize
                v-model="post.description"
                :loading="isLoading" 
                :disabled="isLoading"
                :min-height="50"
                :max-height="200"
                class="bodyinput"
            />
        </b-field>
        <div class="content has-text-centered">
            <img :src="post.image" alt="Image" style="width: 30%">
        </div>
        <div style="display: flex;">
            <b-button 
                type="is-white" 
                outlined
                tag="router-link"
                to="/album"
            >
                <b-icon pack="fas" icon="arrow-left" style="margin-right: 3px"></b-icon>
                Back
            </b-button>
            <div style="display: inline-block; flex-grow: 1"></div>
            <b-button type="is-success" style="color: black" @click="update()" :loading="isLoading" :disabled="isLoading">
                <b-icon pack="fas" icon="check" style="margin-right: 3px"></b-icon>
                Save
            </b-button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: [String, Number],
            required: true
        }
    },
    data() {
        return {
            post: null,
            isLoading: false
        }
    },
    created() {
        this.getImagePost();
    },
    methods: {
        update() {
            this.isLoading = true;
            this.axios
                .post('/backend/api/image-posts/update.php', 
                    { post: this.post },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.$router.push({ name: 'album' });
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        getImagePost() {
            this.isLoading = true;
            this.axios
                .get(
                    '/backend/api/image-posts/get.php',
                    { params: { id: this.id } },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.post = response.data;
                }) 
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.isLoading = false;
                })
        }
    }
}
</script>

<style scoped>
    .bodyinput {
        width: 100%; 
        padding: 5px; 
        border-radius: 5px; 
        border-color: #b5b5b5; 
        box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1); 
        background-color: white; 
        border-radius: 4px; 
        color: #363636; 
        border: 1px solid transparent;
    }
</style>