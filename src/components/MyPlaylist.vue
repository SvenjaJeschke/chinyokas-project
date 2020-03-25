<template>
    <div style="display: flex">
        <audio
            v-if="currentSong"
            :src="currentSong.url" 
            controls 
            @ended="switchToNext"
            ref="playlist"
            style="background-color: #ffffff; margin-right: 10%; max-height: 40px"
        ></audio>
        <div>
            <div v-for="song in songs" :key="song.id">
                <b-tag 
                    class="playlist-title"
                    :closable="admin" 
                    @close="deleteSong(song.id)" 
                    type="is-primary"
                    @click.native="switchTo(song.playlist_id)"
                >
                    {{ song.name }}
                </b-tag>
            </div>
        </div>
    </div>
</template>

<script>
import {EventBus} from '../event-bus';

export default {
    data() {
        return {
            songs: [],
            currentSong: null,
            admin: false
        }
    },
    watch: {
        admin() {
            this.checkAdmin();
        }
    },
    mounted() {
        this.getSongs(true);
        EventBus.$on('song-was-added', () => {
            this.getSongs();
        });
        this.checkAdmin();
    },
    methods: {
        getSongs(firstLoading) {
            this.axios
                .get('/backend/api/playlist-song/all.php')
                .then(response => {
                    this.songs = response.data;
                    if (firstLoading) {
                        this.currentSong = this.songs[0];
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
        },
        switchTo(playlist_id) {
            this.$refs.playlist.pause();
            this.currentSong = this.songs[playlist_id];
            this.$nextTick(() => {
                this.$refs.playlist.play();
            })
        },
        switchToNext() {
            if (this.currentSong.playlist_id + 1 < this.songs.length) {
                this.currentSong = this.songs[this.currentSong.playlist_id + 1];
                this.$nextTick(() => {
                    this.$refs.playlist.play();
                })
            } else {
                this.$refs.playlist.pause();
            }
        },
        deleteSong(id) {
            this.axios
                .post('/backend/api/playlist-song/delete.php', 
                    { id },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getSongs();
                })
        },
        checkAdmin() {
            const password = localStorage.getItem('password');
            this.axios
                .get(
                    '/backend/api/auth/checkadmin.php',
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
    .playlist-title:hover {
        cursor: pointer;
    }
</style>