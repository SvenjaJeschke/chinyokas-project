<template>
    <div>
        <h1>Create a new Image Post</h1>
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
            <b-field v-if="!post.image">
                <input type="file" ref="file" @change="onChange">
            </b-field>
            <img v-else :src="url" alt="Image Preview" style="width: 50%">
        </div>
        <div style="display: flex;">
            <b-button 
                type="is-white" 
                outlined
                tag="router-link"
                to="/blog"
            >
                <b-icon pack="fas" icon="arrow-left" style="margin-right: 3px"></b-icon>
                Back
            </b-button>
            <div style="display: inline-block; flex-grow: 1"></div>
            <b-button type="is-success" style="color: black" @click="create()" :loading="isLoading" :disabled="isLoading">
                <b-icon pack="fas" icon="check" style="margin-right: 3px"></b-icon>
                Create
            </b-button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: {
                title: null,
                description: null,
                image: null
            },
            isLoading: false,
            url: null
        }
    },
    methods: {
        create() {
            this.isLoading = true;
            let formData = new FormData();
            formData.append('title', this.post.title);
            formData.append('description', this.post.description);
            formData.append('file', this.post.image);
            this.axios
                .post('http://localhost:8080/backend/api/image-posts/create.php', 
                    formData,
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    if (response.data.message === 'Your new image post was created.') {
                        this.$router.push({ name: 'album' });
                    }
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        onChange() {
            let image = this.$refs.file.files[0];
            this.post.image = image;
            this.url = URL.createObjectURL(image);
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