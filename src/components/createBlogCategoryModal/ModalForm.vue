<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Add new blog category</p>
            </header>
            <section class="modal-card-body">
                <b-field label="Name">
                    <b-input
                        type="name"
                        v-model="name"
                        placeholder="Enter a name for your category"
                        required
                    >
                    </b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <b-button class="button is-primary" @click="create()" :loading="isLoading">Create</b-button>
            </footer>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: null,
            isLoading: false
        }
    },
    methods: {
        create() {
            this.isLoading = true;
            this.axios
                .post('http://localhost:8080/backend/api/blog-category/create.php', 
                    { name: this.name },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.$parent.close();
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