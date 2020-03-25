<template>
    <form action="">
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Add a new song</p>
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
                <b-button class="button is-primary" @click="create" :loading="isLoading">Add</b-button>
            </footer>
        </div>
    </form>
</template>

<script>
import {EventBus} from '../event-bus';

export default {
    data() {
        return {
            song: {
                name: null,
                url: null
            },
            isLoading: false
        }
    },
    methods: {
        create() {
            this.isLoading = true;
            this.axios
                .post('/backend/api/playlist-song/create.php', 
                    { song: this.song },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.$parent.close();
                    EventBus.$emit('song-was-added');
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