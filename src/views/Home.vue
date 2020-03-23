<template>
    <div>
        <h1>Welcome to my website!</h1>
        <p>
            This is my own personal website that I use for posting blogs as well as trying out new 
            stuff and playing around with my knowledge in programming and web developing. 
            It uses Vuejs, a PHP backend and a MySQL Database. Feel free to 
            visit the Music page, read my blogs or leave a comment. More content coming soon! 
        </p>
        <div style="display: flex">
            <section class="website-content-section">
                <h1>Latest Blog Post</h1>
                <router-link :to="'/view-blog-post/' + latestBlogPost.id">{{ latestBlogPost.title }}</router-link>
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
    created() {

    },
    methods: {
        getLatestBlogPost() {
            
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
    }
</style>