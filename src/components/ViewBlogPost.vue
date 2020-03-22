<template>
    <div>
        
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
                    });
            } else {
                this.$router.push({ name: 'blog-view' });
            }
        }
    }
}
</script>

<style>

</style>