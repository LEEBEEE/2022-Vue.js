<template>
    <!-- <img v-bind:src="imgSrc"> -->
    <img class="imgsize" :src="imgSrc">
</template>

<script>
export default {
    data() {
        return {
            imgSrc: 'https://img.vogue.co.kr/vogue/2021/12/style_61c299401f4b3-1200x801.jpeg'
        }
    }
}
</script>

<style scoped>
    .imgsize {width: 700px;}
</style>