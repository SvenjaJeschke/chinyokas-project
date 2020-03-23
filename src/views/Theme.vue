<template>
    <div>
        <h1>Theme</h1>
        <h2>Create a new theme</h2>
        <b-field label="Background Image URL">
                <b-input v-model="newTheme.backgroundImage"></b-input>
            </b-field>
        <div style="display: flex">
            <b-field label="Navigation Bar Type" style="width: 49%">
                <b-select v-model="newTheme.navbarType" expanded>
                    <option
                        v-for="(type, index) in navbarTypes"
                        :key="index"
                        :value="type"
                    >
                        {{ type }}
                    </option>
                </b-select>
            </b-field>
            <div style="display: inline-block; flex-grow: 1"></div>
            <b-field label="Border Color" style="width: 49%">
                <b-input v-model="newTheme.borderColor"></b-input>
            </b-field>
        </div>
        <b-button 
            type="is-success" 
            style="color: black; margin: 5px; display: inline-block;" 
            @click="create()"
            :loading="isLoading"
            :disabled="isLoading"
        >
            <b-icon pack="fas" icon="check" style="margin-right: 3px"></b-icon>
            Create theme
        </b-button>
        <h2>Select an existing theme</h2>
        <b-progress v-if="themesAreLoading" type="is-success"></b-progress>
        <div 
            class="card"
            v-for="theme in themes"
            :key="theme.id"
            style="width: 24%; padding: 0; display: inline-block; margin: 5px"
        >
            <b-navbar class="card-header" :type="theme.navbarType">
                <template slot="brand">
                    <b-tooltip label="Edit theme">
                        <b-button @click="editThemeData(theme)" style="margin: 10px" outlined type="is-white">
                            <b-icon 
                                pack="fas" 
                                icon="pen"
                            ></b-icon>
                        </b-button>
                    </b-tooltip>
                </template>    
                <template slot="end">
                    <b-checkbox 
                        type="is-white" 
                        style="margin-right: 5px" 
                        @input="changeTheme(theme.id, theme.is_current)" 
                        v-model="theme.is_current"
                    >
                        Use this theme
                    </b-checkbox>
                </template>
            </b-navbar>
            <div 
                class="card-content" 
                :style="{
                    padding: '5px', 
                    backgroundColor: theme.borderColor, 
                    borderRadius: '4px'
                }"
            >
                <img :src="theme.backgroundImage" alt="Theme-image">
            </div>
        </div>
        <edit-theme-modal v-model="showEditThemeModal" :theme="editTheme"></edit-theme-modal>         
    </div>
</template>

<script>
import {EventBus} from './../event-bus.js';
import EditThemeModal from '../components/editThemeModal/EditThemeModal';

export default {
    components: {
        'edit-theme-modal': EditThemeModal
    },
    data() {
        return {
            themes: [],
            newTheme: {
                backgroundImage: null,
                borderColor: null,
                navbarType: null
            },
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
            isLoading: false,
            showEditThemeModal: false,
            editTheme: null,
            themesAreLoading: false
        }
    },
    created() {
        this.getThemes();
    },
    methods: {
        getThemes() {
            this.themesAreLoading = true;
            this.axios
                .get('http://localhost:8080/backend/api/theme/all.php')
                .then(response => {
                    this.themes = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.themesAreLoading = false;
                })
        },
        create() {
            this.isLoading = true;
            this.axios
                .post(
                    'http://localhost:8080/backend/api/theme/create.php',
                    { theme: this.newTheme },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                    this.getThemes();
                })
        },
        changeTheme(id, checked) {
            if (checked) {
                this.axios
                    .post(
                        'http://localhost:8080/backend/api/theme/change.php',
                        { id },
                        { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                    )
                    .then(response => {
                        this.$buefy.toast.open(response.data.message);
                        EventBus.$emit('theme-was-changed');
                        this.getThemes();
                    })
            }
        },
        editThemeData(theme) {
            this.showEditThemeModal = true;
            this.editTheme = theme;
        }
    }
}
</script>