<template>
    <div>
        <h1>Create a new Post</h1>
        <div style="display: flex">
            <b-field label="Title" style="width: 50%">
                <b-input v-model="post.title"></b-input>
            </b-field>
            <b-field label="Category" style="margin-left: 10px; width: 30%">
                <b-select v-model="post.category_id" expanded :loading="isLoading" :disabled="isLoading">
                    <option 
                        v-for="category in categories" 
                        :key="category.id" 
                        :value="parseInt(category.id)"
                    >
                        {{ category.name }}
                    </option>
                </b-select>
            </b-field>
            <b-field label="Make post public?" style="margin-left: 15px;">
                <b-tooltip 
                    label="If you don't check this option, the blog post will be only visible to you."
                >
                    <b-checkbox v-model="post.is_public">{{ post.is_public ? 'show it to the world' : 'no, save as draft' }}</b-checkbox>
                </b-tooltip>
            </b-field>
        </div>
        <b-field label="Body">
            <textarea-autosize
                v-model="post.body"
                :loading="isLoading" 
                :disabled="isLoading"
                :min-height="100"
                :max-height="4000"
                class="bodyinput"
            />
        </b-field>
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
                body: null,
                is_public: false,
                category_id: null
            },
            categories: [],
            isLoading: false
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.isLoading = true;
            this.axios
                .get('http://localhost:8080/backend/api/blog-category/all.php')
                .then(response => {
                    this.categories = response.data;
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
        },
        create() {
            this.isLoading = true;
            this.axios
                .post('http://localhost:8080/backend/api/blog-post/create.php', 
                    { post: this.post },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    if (response.data.message === 'Your new blog post was created.') {
                        this.$router.push({ name: 'blog' });
                    }
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
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