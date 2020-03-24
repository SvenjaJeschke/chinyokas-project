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
                            {{ type.substring(3, type.length) }}
                        </option>
                    </b-select>
                </b-field>
                
                <div 
                    style="display: inline-block; width: 100%"
                >
                    <b style="color: black">Border Color</b>
                    <b-collapse
                        aria-id="contentIdForA11y2"
                        class="panel"
                        animation="slide"
                        :open.sync="colorPanelIsOpen"
                        style="width: 100%"
                    >
                        <div
                            slot="trigger"
                            role="button"
                            aria-controls="contentIdForA11y2"
                            style="display: inline-block; width: 100%"
                        >
                            <b-field style="width: 100%">
                                <b-input 
                                    v-model="theme.borderColor" 
                                ></b-input>
                            </b-field>
                        </div>
                        <div 
                            class="panel-block"
                        >
                            <color-picker v-model="theme.borderColor"></color-picker>
                        </div>
                    </b-collapse>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <b-button class="button is-primary" @click="update()" :loading="isLoading">Save</b-button>
            </footer>
        </div>
    </form>
</template>

<script>
import ColorPicker from '../colorPickerModal/ColorPicker';

export default {
    components: {
        'color-picker': ColorPicker
    },
    props: {
        themeData: {
            type: Object,
            default: () => {
                return {
                    backgroundImage: null,
                    borderColor: '#FFFFFF',
                    navbarType: null
                }
            }
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
            ],
            colorPanelIsOpen: false
        }
    },
    created() {
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