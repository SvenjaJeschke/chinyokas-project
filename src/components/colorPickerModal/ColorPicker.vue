<template>
    <div style="width: 220px">
        <color-picker
            style="width: 100%"
            :color="value"
            @changeColor="changeColor"
            :sucker-hide="false"
            :sucker-canvas="suckerCanvas"
            :sucker-area="suckerArea"
        />
    </div>
</template>

<script>
import colorPicker from '@caohenghu/vue-colorpicker';

export default {
    components: {
        'color-picker': colorPicker
    },
    props: {
        value: {
            type: String,
            default: '#ffffff'
        }
    },
    data() {
        return {
            suckerCanvas: null,
            suckerArea: [],
            isSucking: false
        }
    },
    methods: {
        changeColor(color) {
            this.$emit('input', color.hex);
        }
    }
}
</script>