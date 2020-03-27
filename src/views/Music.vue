<template>
    <div>
        <h1>Music</h1>
        <my-playlist></my-playlist>
        <br>
        <b-button
            v-if="admin"
            style="color: black"
            type="is-success"
            @click="showAddSongModal = true"
        >
            Add a song
        </b-button>
        <br><br>
        <h2>My favorite playlists on Spotify</h2><br>
        <div v-if="!loading">
            <div v-for="(url, index) in urls" :key="index" style="display: inline-block; width: 25%">
                <spotify-player
                    :url="url" 
                ></spotify-player>
            </div>
        </div>
        <b-button v-else loading type="is-dark" style="width: 300px"></b-button><br><br>
        <div v-if="admin">
            <h2>Add new Spotify playlist</h2>
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
        <b-modal 
            :active.sync="showAddSongModal"
            has-modal-card
            trap-focus
            aria-role="dialog"
            aria-modal
        >
            <add-song-modal></add-song-modal>
        </b-modal>
    </div>
</template>

<script>
import SpotifyPlayer from './../components/SpotifyPlayer';
import MyPlaylist from '../components/MyPlaylist';
import AddSongModal from '../components/AddSongModal';

export default {
    components: {
        'spotify-player': SpotifyPlayer,
        'my-playlist': MyPlaylist,
        'add-song-modal': AddSongModal
    },
    data() {
        return {
            urls: [],
            newUrl: null,
            newName: null,
            loading: true,
            admin: false,
            showAddSongModal: false
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
                    .post('/backend/api/playlist/create.php', 
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
            this.axios.get('/backend/api/playlist/urls.php').then(response => {
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
            if (password) {
                this.axios
                    .get(
                    '/backend/api/auth/checkadmin.php',
                    { params: { password: password } },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
                    .then(response => {
                    this.admin = response.data.admin;
                    })
            } else {
                this.admin = false;
            }
        }
    }
}
</script>

<style scoped>
</style>