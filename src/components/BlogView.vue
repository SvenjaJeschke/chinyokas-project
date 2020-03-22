<template>
    <div>
        <h1>Chinyokas Blog</h1>
        <div style="display: flex">
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
            :open="openCollapseItem == index"
            @open="openCollapseItem = index"
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
                            <b-table-column field="title" label="Title" width="1200">
                                <router-link :to="'/blog/' + props.row.id">
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
    </div>
</template>

<script>
import CreateBlogCategoryModal from './CreateBlogCategoryModal';

export default {
    components: {
        'create-blog-category-modal': CreateBlogCategoryModal
    },
    data() {
        return {
            collapses: [],
            openCollapseItem: 0
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.axios
                .get('http://localhost:8080/backend/api/blog-category/all.php')
                .then(response => {
                    this.collapses = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

<style scoped>

</style>