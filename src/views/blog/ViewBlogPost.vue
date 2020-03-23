<template>
    <div>
        <h1>View Blog Post</h1>
        <h5 v-if="post.category">in <b>{{ post.category.name }}</b></h5>
        <br>
        <div class="card">
            <header class="card-header" style="display: flex">
                <p class="card-header-title">
                    {{ post.title }}
                </p>
                <div style="flex-grow: 1; display: inline-block"></div>
                <span style="padding: 10px">
                    {{ $date(post.created_at).format('DD/MM/YYYY HH:mm') }}
                </span>
                <b-tooltip label="Edit" position="is-bottom">
                    <b-button 
                        type="is-white" 
                        outlined
                        style="color: black; margin: 5px" 
                        tag="router-link" 
                        :to="'/edit-blog-post/' + post.id"
                    >
                        <b-icon pack="fas" icon="pen"></b-icon>
                    </b-button>
                </b-tooltip>
            </header>
            <div class="card-content">
                <div class="content">
                    <div v-html="post.body"></div>
                </div>
            </div>
            <footer class="card-footer">
                <a class="card-footer-item" @click="showCommentField = !showCommentField">Comment</a>
            </footer>
        </div>
        <br>
        <div style="display: flex">
            <div style="display: inline-block; width: 60%">
                <div class="card" v-for="comment in comments" :key="comment.id" style="margin-top: 5px">
                    <header class="card-header" style="display: flex">
                        <p class="card-header-title">
                            Comment by {{ comment.username }}
                        </p>
                        <div style="flex-grow: 1; display: inline-block"></div>
                        <span style="padding: 10px">
                            {{ $date(comment.created_at).format('DD/MM/YYYY HH:mm') }}
                        </span>
                    </header>
                    <div class="card-content">
                        {{ comment.content }}
                    </div>
                </div>
            </div>
            <div style="display: inline-block; flex-grow: 1"></div>
            <div v-show="showCommentField"  class="card" style="width: 39%; height: 300px">
                <div class="card-content">
                    <div style="display: flex">
                        <span>What's your name?</span>
                        <div style="display: inline-block; flex-grow: 1"></div>
                        <b-tooltip label="Please tell me who you are so I know who wrote this :)">
                            <b-field>
                                <b-input v-model="newComment.username"></b-input>
                            </b-field>
                        </b-tooltip>
                    </div>
                    <br>
                    Write a comment
                    <b-field>
                        <b-input v-model="newComment.content" type="textarea"></b-input>
                    </b-field>
                </div>
                <footer class="card-footer">
                    <b-button 
                        type="is-black" 
                        style="margin: 5px"
                        @click="sendComment()"
                    >
                        Send
                    </b-button>
                </footer>
            </div>
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
            post: {},
            admin: false,
            showCommentField: false,
            newComment: {
                username: null,
                content: null,
                blog_post_id: parseInt(this.id)
            },
            comments: []
        }
    },
    created() {
        this.checkAdmin();
        this.getPost();
        this.getComments();
        if (localStorage.getItem('username')) {
            this.newComment.username = localStorage.getItem('username');
        }
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
                this.$router.push({ name: 'blog' });
            }
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
        },
        sendComment() {
            localStorage.setItem('username', this.newComment.username);
            this.axios
                .post(
                    'http://localhost:8080/backend/api/blog-comment/create.php',
                    { comment: this.newComment },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getComments();
                })
        },
        getComments() {
            this.axios
                .get(
                    'http://localhost:8080/backend/api/blog-comment/blog-comments.php',
                    { params: { blog: this.id } }
                )
                .then(response => {
                    this.comments = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                });
        }
    }
}
</script>

<style scoped>
    h5 {
        font-size: 10pt;
    }
</style>