<template>
    <div>
        <h1 class="blogheading">View Blog Post</h1>
        <h5 v-if="post.category">in <b>{{ post.category.name }}</b></h5>
        <br>
        <div class="card">
            <header class="card-header" style="display: flex">
                <p class="card-header-title">
                    {{ post.title }}
                </p>
                <div style="flex-grow: 1; display: inline-block"></div>
                <span style="padding: 5px">
                    {{ $date(post.created_at).format('DD/MM/YYYY HH:mm') }}
                </span>
            </header>
            <div class="card-content">
                <div class="content">
                    <div v-html="post.body"></div>
                </div>
            </div>
            <footer class="card-footer">
                <router-link :to="'/edit-blog-post/' + post.id" class="card-footer-item">Edit</router-link>
            </footer>
        </div>
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
            post: {}
        }
    },
    created() {
        this.getPost();
    },
    methods: {
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
                        this.$buefy.toast.open({
                            message: 'Something went wrong while loading the data... Please reload the page.',
                            type: 'is-danger'
                        })
                    });
            } else {
                this.$router.push({ name: 'blog-view' });
            }
        }
    }
}
</script>

<style scoped>
    .blogheading {
        border-bottom: white;
        border-bottom-style: solid;
        border-bottom-width: 1px;
    }
    h5 {
        font-size: 10pt;
    }
</style>