<template>
    <div>
        <h1>Music</h1>
        <div v-if="!loading">
            <div v-for="(url, index) in urls" :key="index" style="display: inline-block; width: 25%">
                <spotify-player
                    :url="url" 
                ></spotify-player>
            </div>
        </div>
        <b-button v-else loading type="is-dark" style="width: 300px"></b-button><br><br>
        <div v-if="admin">
            <h2>Add new Playlist</h2>
            <b-field label="Playlist Name:" style="width: 40%">
                <b-input v-model="newName" style="width: 100%"></b-input>
            </b-field>
            <b-tooltip 
                label="Go to playlist on spotify -> Share -> Copy Playlist Link" 
                position="is-bottom" 
                style="width: 80%"
            >
                <b-field label="Spotify Playlist URL:" style="width: 100%">
                    <b-input v-model="newUrl"></b-input>
                </b-field>
            </b-tooltip>
            <b-button 
                style="margin: 30px; color: black"
                type="is-success" 
                @click="createNewPlaylist"
            >
                Create
            </b-button>
        </div>
    </div>
</template>

<script>
import SpotifyPlayer from './../components/SpotifyPlayer';

export default {
    components: {
        'spotify-player': SpotifyPlayer
    },
    data() {
        return {
            urls: [],
            newUrl: null,
            newName: null,
            loading: true,
            admin: false
        }
    },
    watch: {
        admin() {
            this.checkAdmin();
        }
    },
    created() {
        this.checkAdmin();
        this.getPlaylists();
    },
    methods: {
        createNewPlaylist() {
            this.loading = true;
            if (this.newUrl) {
                this.axios
                    .post('http://localhost:8080/backend/api/playlist/create.php', 
                        { params: { name: this.newName, url: this.newUrl } }, 
                        { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
                    .then(() => {
                        this.getPlaylists();
                    })
                    .catch(error => {
                        console.log(error);
                    })
            } else {
                this.warningNoUrl();
            }
            this.loading = false;
        },
        getPlaylists() {
            this.loading = true;
            this.axios.get('http://localhost:8080/backend/api/playlist/urls.php').then(response => {
                this.urls = response.data;
            }).catch(error => {
                console.log(error);
            }).finally(() => {
                this.loading = false;
            })
        },
        warningNoUrl() {
            this.$buefy.toast.open({
                message: 'Please enter an URL to your Spotify playlist.',
                type: 'is-danger'
            });
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
        }
    }
}
</script>

<style scoped>
</style>