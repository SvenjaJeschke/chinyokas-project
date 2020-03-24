<template>
    <b-modal :active.sync="value"
        has-modal-card
        trap-focus
        aria-role="dialog"
        aria-modal
    >
        <modal-form :theme-data="theme"></modal-form>
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
        theme: {
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
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    }
}
</script>

<style>

</style>