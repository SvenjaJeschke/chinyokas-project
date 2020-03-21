<template>
    <div style="display: inline-block">
        <embed 
            :src="url" 
            frameborder="0" 
            allowtransparency="true" 
            allow="encrypted-media"
            class="player"
        >
    </div>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
    .player {
        max-height: 77px;
        display: inline-block;
        margin: 5px;
    }
</style>