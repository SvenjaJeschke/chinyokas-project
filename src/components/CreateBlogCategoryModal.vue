<template>
    <div style="display: inline-block">
        <b-button type="is-success" style="color: black; margin: 5px; display: inline-block" @click="showCreateBlogCategoryModal = true">
            <b-icon pack="fas" icon="folder-plus" style="margin-right: 3px"></b-icon>
            Add new blog category
        </b-button>
        <b-modal :active.sync="showCreateBlogCategoryModal"
            has-modal-card
            trap-focus
            aria-role="dialog"
            aria-modal
        >
            <modal-form></modal-form>
        </b-modal>
    </div>
</template>

<script>
import ModalForm from './ModalForm';

export default {
    components: {
        'modal-form': ModalForm
    },
    data() {
        return {
            showCreateBlogCategoryModal: false
        }
    }
}
</script>

<style>

</style>