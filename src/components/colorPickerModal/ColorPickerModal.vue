<template>
    <div style="display: inline-block; width: 49%">
        <b-field label="Border Color" style="width: 100%">
            <b-input :value="value" @focus="showModal = true"></b-input>
        </b-field>
        <b-modal :active.sync="showModal"
            has-modal-card
            trap-focus
            aria-role="dialog"
            aria-modal
        >
            <color-picker v-model="color"></color-picker>
        </b-modal>
    </div>
</template>

<script>
import ColorPicker from './ColorPicker';

export default {
    components: {
        'color-picker': ColorPicker
    },
    props: {
        value: {
            type: String,
            default: '#ffffff'
        }
    },
    data() {
        return {
            showModal: false,
            color: '#ffffff'
        }
    },
    watch: {
        value() {
            this.$emit('input', this.value);
        },
        color() {
            this.$emit('input', this.color);
        }
    },
    mounted() {
        this.color = this.value;
    }
}
</script>