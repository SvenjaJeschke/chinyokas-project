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
            <div style="width: 49%; display: inline-block">
                <div>
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
                <div>
                    <section class="website-content-section">
                        <h3 style="display: flex">
                            My favorite song at the moment
                            <div style="display: inline-block; flex-grow: 1"></div>
                            <b-button 
                                v-if="admin" 
                                @click="showEditSongModal = true"
                                outlined 
                                type="is-white"
                            >
                                <b-icon 
                                    pack="fas" 
                                    icon="pen"
                                ></b-icon>
                            </b-button>
                        </h3>
                        <p>
                            {{ song.name }}<br><br>
                            <audio :src="song.url" controls></audio>
                        </p>
                    </section>
                </div>
            </div>
            <div style="flex-grow: 1; display: inline-block"></div>
            <div class="website-content-section image-post">
                <h3>My newest drawing</h3><br>
                <div class="card-image">
                    <figure class="image is-4by3">
                        <div>
                            <img :src="latestImagePost.image" :alt="latestImagePost.title">
                        </div>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="card-header" style="display: flex">
                        <p class="card-header-title" style="color: #e3e3e3">
                            {{latestImagePost.title}}
                        </p>
                        <div style="flex-grow: 1; display: inline-block"></div>
                        <span style="padding: 10px">
                            {{ $date(latestImagePost.created_at).format('DD/MM/YYYY HH:mm') }}
                        </span>
                    </div>
                    <div class="content">
                        {{ trimmedImagePostBody }}
                    </div>
                </div>
            </div>
        </div>
        <change-favorite-song-modal 
            :current-song="song" 
            v-model="showEditSongModal" 
            @song-was-updated="getFavoriteSong"
        ></change-favorite-song-modal>
    </div>
</template>

<script>
import ChangeFavoriteSongModal from '../components/changeFavoriteSongModal/ChangeFavoriteSongModal';

export default {
    components: {
        'change-favorite-song-modal': ChangeFavoriteSongModal
    },
    data() {
        return {
            latestBlogPost: {},
            latestImagePost: {},
            admin: false,
            song: null,
            showEditSongModal: false
        }
    },
    computed: {
        trimmedBlogBody() {
            if (this.latestBlogPost.body.length > 490) {
                return `<h5>${this.latestBlogPost.body.substring(0, 490)}...</h5>`;
            }
            return `<h5>${this.latestBlogPost.body}</h5>`;
        },
        trimmedImagePostBody() {
            if (this.latestImagePost.description.length > 210) {
                return this.latestImagePost.description.substring(0, 210) + '...'
            }
            return this.latestImagePost.description
        }
    },
    watch: {
        admin() {
            this.checkAdmin();
        }
    },
    created() {
        this.getLatestBlogPost();
        this.getLatestImagePost();
        this.checkAdmin();
        this.getFavoriteSong();
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
        },
        getLatestImagePost() {
            this.axios
                .get('http://localhost:8080/backend/api/image-posts/latest.php')
                .then(response => {
                    this.latestImagePost = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
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
        },
        getFavoriteSong() {
            this.axios
                .get('http://localhost:8080/backend/api/favorite-song/get.php')
                .then(response => {
                    this.song = response.data;
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
    .image-post {
        width: 47%;
        display: inline-block; 
        margin: 5px;
        padding: 10px; 
        background-color: #00000000; 
        color: #e3e3e3;
    }
    img {
        max-width:100%;
        max-height:100%;
        object-fit: contain;
    }
</style>