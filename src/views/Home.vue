<template>
    <div>
        <h1>Welcome to my website!</h1>
        <p>
            This is my own personal website that I use for posting blogs as well as trying out new 
            stuff and playing around with my knowledge in programming and web developing. 
            It uses Vuejs, a PHP backend and a MySQL Database. Feel free to 
            visit the Music page, read my blogs or leave a comment. More content coming soon! 
        </p>
        <div style="display: flex; width: 50%">
            <section class="website-content-section">
                <h3>Latest Blog Post</h3>
                <h5>in <b>{{ latestBlogPost.category.name }}</b></h5>
                <br>
                <div style="display: flex">
                    <router-link :to="'/view-blog-post/' + latestBlogPost.id" class="blog-post-link">
                        {{ latestBlogPost.title }}
                    </router-link>
                    <div style="display: inline-block; flex-grow: 1"></div>
                    {{ $date(latestBlogPost.created_at).format('DD/MM/YYYY HH:mm') }}
                </div><br>
                <div v-html="trimmedBlogBody"></div>
            </section>
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            latestBlogPost: {}
        }
    },
    computed: {
        trimmedBlogBody() {
            return `<h5>${this.latestBlogPost.body.substring(0, 490)}...</h5>`;
        }
    },
    created() {
        this.getLatestBlogPost();
    },
    methods: {
        getLatestBlogPost() {
            this.axios
                .get('http://localhost:8080/backend/api/blog-post/latest.php')
                .then(response => {
                    this.latestBlogPost = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
        }
    }
}
</script>

<style scoped>
    p {
        padding: 20px;
    }
    .website-content-section {
        border-color: #d2d2d2; 
        border-width: 1px; 
        margin: 20px; 
        padding: 10px; 
        border-style: solid;
        border-radius: 4px;
        width: 100%
    }
    .blog-post-link {
        color: #57f9ff;
    }
    .blog-post-link:hover {
        color: #d6fcfd;
    }
</style>