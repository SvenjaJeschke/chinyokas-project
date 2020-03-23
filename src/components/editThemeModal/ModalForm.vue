<template>
    <form action="">
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Edit Theme</p>
            </header>
            <section class="modal-card-body">
                <b-field label="Background Image URL">
                    <b-input
                        v-model="theme.backgroundImage"
                    ></b-input>
                </b-field>
                <b-field label="Navigation Bar Type">
                <b-select v-model="theme.navbarType" expanded>
                    <option
                        v-for="(type, index) in navbarTypes"
                        :key="index"
                        :value="type"
                    >
                        {{ type }}
                    </option>
                </b-select>
            </b-field>
                <b-field label="Border Color">
                    <b-input
                        v-model="theme.borderColor"
                    ></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <b-button class="button is-primary" @click="update()" :loading="isLoading">Save</b-button>
            </footer>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        themeData: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            isLoading: false,
            theme: {},
            navbarTypes: [
                'is-white', 
                'is-black', 
                'is-light', 
                'is-dark', 
                'is-primary', 
                'is-info', 
                'is-success', 
                'is-warning', 
                'is-danger'
            ]
        }
    },
    mounted() {
        this.theme = this.themeData;
    },
    methods: {
        update() {
            this.isLoading = true;
            this.axios
                .post('http://localhost:8080/backend/api/theme/update.php', 
                    { theme: this.theme },
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