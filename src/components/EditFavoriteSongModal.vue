<template>
    <form action="">
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Edit your favorite song</p>
            </header>
            <section class="modal-card-body">
                <b style="color: black">Name</b>
                <b-field>
                    <b-input
                        type="name"
                        v-model="song.name"
                        required
                    ></b-input>
                </b-field>
                <b style="color: black">Song URL</b>
                <b-field>
                    <b-input
                        type="url"
                        v-model="song.url"
                        required
                    ></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <b-button class="button is-primary" @click="update" :loading="isLoading">Update</b-button>
            </footer>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        currentSong: {
            type: Object,
            default: () => {
                return {
                    name: null,
                    url: null
                }
            }
        }
    },
    data() {
        return {
            song: null,
            isLoading: false
        }
    },
    created() {
        if (this.currentSong) {
            this.song = this.currentSong;
        }
    },
    methods: {
        update() {
            this.isLoading = true;
            this.axios
                .post('/backend/api/favorite-song/update.php', 
                    { song: this.song },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.$parent.close();
                    this.$emit('song-was-updated');
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                })
        }
    }
}
</script>