<template>
    <tr>
        <td>{{ item.rank }}</td>
        <td>{{ item.movieNm }}</td>
        <td>{{ item.openDt }}</td>
        <td>{{ commaAudiAcc }}</td>
        <td>{{ commasalesAcc }}</td>
    </tr>
</template>

<script>
export default {
    props: {
        item: Object
    },
    methods: {
        getComma(str){
            return str.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
    },
    computed: {
        commaAudiAcc: function() {
            return this.getComma(this.item.audiAcc);
        },
        commasalesAcc: function() {
            return this.getComma(this.item.salesAcc);
        },
    }
}
</script>

<style>

</style>