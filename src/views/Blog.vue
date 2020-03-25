<template>
    <div>
        <h1>Chinyokas Blog</h1>
        <div v-if="admin" style="display: flex">
            <div style="flex-grow: 1; display: inline-block"></div>
            <create-blog-category-modal @category-was-created="getCategories"></create-blog-category-modal>
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
            @close="removeFromArray(openCollapseItems, index)"
            type="is-dark"
        >
            <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                    <b-input 
                        tabindex="0"
                        @focusout.native="removeFromArray(editCategoryName, collapse.id)"
                        ref="input"
                        v-show="editCategoryName.includes(collapse.id)"
                        v-model="collapse.name"
                        @keydown.native.enter="updateCategoryName(collapse)"
                        style="width: 40%"
                        :autofocus="true"
                    ></b-input>
                    <span v-if="!editCategoryName.includes(collapse.id)">{{ collapse.name }}</span>
                    <b-tooltip label="Edit" position="is-bottom">
                        <b-button 
                            :disabled="editCategoryName.includes(collapse.id)"
                            v-if="admin"
                            type="is-white" 
                            outlined
                            style="color: black; margin: 5px" 
                            @click="openEditCategoryName(collapse.id)"
                        >
                            <b-icon pack="fas" icon="pen"></b-icon>
                        </b-button>
                    </b-tooltip>
                    <b-tooltip label="Delete" position="is-bottom">
                        <b-button 
                            v-if="admin"
                            type="is-danger"
                            style="margin: 5px" 
                            @click="confirmDeleteCategory(collapse)"
                        >
                            <b-icon pack="fas" icon="trash"></b-icon>
                        </b-button>
                    </b-tooltip>
                </p>
                <a class="card-header-icon">
                    <b-icon
                        :icon="props.open ? 'chevron-up' : 'chevron-down'" pack="fas">
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
                            <b-table-column field="actions" label="Actions" style="display: flex">
                                <b-tooltip label="Edit" position="is-bottom">
                                    <b-button 
                                        v-if="admin"
                                        type="is-white" 
                                        outlined
                                        style="color: black; margin: 5px" 
                                        tag="router-link" 
                                        :to="'/edit-blog-post/' + props.row.id"
                                    >
                                        <b-icon pack="fas" icon="pen"></b-icon>
                                    </b-button>
                                </b-tooltip>
                                <b-tooltip label="Delete" position="is-bottom">
                                    <b-button 
                                        v-if="admin"
                                        type="is-danger"
                                        style="margin: 5px" 
                                        @click="confirmDeleteBlogPost(props.row.id)"
                                    >
                                        <b-icon pack="fas" icon="trash"></b-icon>
                                    </b-button>
                                </b-tooltip>
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
            openCollapseItems: [],
            isLoading: false,
            admin: false,
            editCategoryName: []
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
        removeFromArray(array, value) {
            for (let i = 0; i < array.length; i++) {
                if (array[i] === value) {
                    array.splice(i, 1);
                }
            }
        },
        confirmDeleteBlogPost(id) {
            this.$buefy.dialog.confirm({
                title: 'Delete blog post',
                message: '<p style="color: black">Are you sure you want to <b>delete</b> this blog post?</p>',
                confirmText: 'Delete post',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteBlogPost(id)
            })
        },
        deleteBlogPost(id) {
            this.removeFromArray(this.openCollapseItems, id);
            this.axios
                .post(
                    'http://localhost:8080/backend/api/blog-post/delete.php',
                    { id: id },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getCategories();
                })
        },
        updateCategoryName(category) {
            this.removeFromArray(this.editCategoryName, category.id);
            this.axios
                .post(
                    'http://localhost:8080/backend/api/blog-category/update.php',
                    { category: category },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getCategories();
                })
        },
        openEditCategoryName(id) {
            this.editCategoryName.push(id)
            this.$refs.input[id].$el.focus();
        },
        confirmDeleteCategory(category) {
            if (category.posts && category.posts.length > 0) {
                this.$buefy.toast.open('Only categories without blog posts can be deleted.');
            } else {
                this.$buefy.dialog.confirm({
                    title: 'Delete category',
                    message: '<p style="color: black">Are you sure you want to <b>delete</b> this category?</p>',
                    confirmText: 'Delete category',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteCategory(category.id)
                })
            }
        },
        deleteCategory(id) {
            this.axios
                .post(
                    'http://localhost:8080/backend/api/blog-category/delete.php',
                    { id },
                    { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } }
                )
                .then(response => {
                    this.$buefy.toast.open(response.data.message);
                    this.getCategories();
                })
        }
    }
}
</script>

<style scoped>

</style>