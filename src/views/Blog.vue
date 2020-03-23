<template>
    <div>
        <h1>Chinyokas Blog</h1>
        <div v-if="admin" style="display: flex">
            <div style="flex-grow: 1; display: inline-block"></div>
            <create-blog-category-modal></create-blog-category-modal>
            <b-button type="is-success" style="color: black; margin: 5px; display: inline-block;" tag="router-link" to="/blog-create">
                <b-icon pack="fas" icon="plus" style="margin-right: 3px"></b-icon>
                Create new blog post
            </b-button>
        </div>
        <b-collapse
            class="card"
            animation="slide"
            v-for="(collapse, index) of collapses"
            :key="index"
            :open="openCollapseItems.includes(index)"
            @open="openCollapseItems.push(index)"
            @close="remove(openCollapseItems, index)"
            type="is-dark"
        >
            <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                    {{ collapse.name }}
                </p>
                <a class="card-header-icon">
                    <b-icon
                        :icon="props.open ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </a>
            </div>
            <div class="card-content">
                <div class="content">
                    <b-table :data="collapse.posts">
                        <template slot-scope="props">
                            <b-table-column field="title" label="Title" width="900">
                                <router-link :to="'/view-blog-post/' + props.row.id">
                                    {{ props.row.title }}
                                </router-link>
                            </b-table-column>
                            <b-table-column field="likes" label="Likes">
                                {{ props.row.likes ? props.row.likes : 0 }}
                            </b-table-column>
                            <b-table-column field="created_at" label="Created at">
                                {{ $date(props.row.created_at).format('DD/MM/YYYY HH:mm') }}
                            </b-table-column>
                        </template>
                    </b-table>
                </div>
            </div>
        </b-collapse>
        <b-progress v-if="isLoading" type="is-success"></b-progress>
    </div>
</template>

<script>
import CreateBlogCategoryModal from './../components/createBlogCategoryModal/CreateBlogCategoryModal';

export default {
    components: {
        'create-blog-category-modal': CreateBlogCategoryModal
    },
    data() {
        return {
            collapses: [],
            openCollapseItems: [0, 1, 2],
            isLoading: false,
            admin: false
        }
    },
    watch: {
        admin() {
            this.checkAdmin();
        }
    },
    created() {
        this.getCategories();
        this.checkAdmin();
        if (localStorage.getItem('openCollapseItems')) {
            this.openCollapseItems = JSON.parse(localStorage.getItem('openCollapseItems'));
        }
    },
    beforeDestroy() {
        localStorage.setItem('openCollapseItems', JSON.stringify(this.openCollapseItems));
    },
    methods: {
        getCategories() {
            this.isLoading = true;
            this.axios
                .get('http://localhost:8080/backend/api/blog-category/all-with-posts.php')
                .then(response => {
                    this.collapses = response.data;
                })
                .catch(error => {
                    console.log(error);
                    this.$buefy.toast.open({
                        message: 'Something went wrong while loading the data... Please reload the page.',
                        type: 'is-danger'
                    })
                })
                .finally(() => {
                    this.isLoading = false;
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
        remove(array, value) {
            for (let i = 0; i < array.length; i++) {
                if (array[i] === value) {
                    array.splice(i, 1);
                }
            }
        }
    }
}
</script>

<style scoped>
</style>