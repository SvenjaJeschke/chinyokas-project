<template>
    <div>
        <h1>Edit Post</h1>
        <div style="display: flex">
            <b-field label="Title" style="width: 50%">
                <b-input v-model="post.title"></b-input>
            </b-field>
            <b-field label="Category" style="margin-left: 10px; width: 30%">
                <b-select v-model="post.category_id" expanded>
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
            <b-input type="textarea" v-model="post.body"></b-input>
        </b-field>
        <b-button type="is-success" style="color: black" @click="update()" :loading="isLoading" :disabled="isLoading">
            <b-icon pack="fas" icon="check" style="margin-right: 3px"></b-icon>
            Save
        </b-button>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            post: {},
            categories: [],
            isLoading: false
        }
    },
    created() {
        this.getCategories();
        this.getPost()
    },
    methods: {
        getCategories() {
            this.axios
                .get('http://localhost:8080/backend/api/blog-category/all.php')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        update() {
            this.isLoading = true;
            this.axios
                .post('http://localhost:8080/backend/api/blog-post/update.php', 
                    { post: this.post },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    if (response.data.message === 'Your blog was updated and saved.') {
                        this.$router.push({ name: 'blog-view' });
                    }
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        getPost() {
            if (this.id) {
                this.axios
                    .get('http://localhost:8080/backend/api/blog-post/get.php', 
                        { params: { id: parseInt(this.id) } },
                        { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                    )
                    .then(response => {
                        this.post = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                this.$router.push({ name: 'blog-view' });
            }
        }
    }
}
</script>

<style scoped>

</style>