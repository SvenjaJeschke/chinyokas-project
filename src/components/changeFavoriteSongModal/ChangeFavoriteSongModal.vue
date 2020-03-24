<template>
    <b-modal 
        :active.sync="value"
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <modal-form :current-song="currentSong" @song-was-updated="$emit('song-was-updated')"></modal-form>
    </b-modal>
</template>

<script>
import ModalForm from './ModalForm';

export default {
    components: {
        'modal-form': ModalForm
    },
    props: {
        value: {
            type: Boolean,
            default: false
        },
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
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    }
}
</script>

<style>

</style>