<template>
    <div>
        <h1>{{ title }}</h1>
        <div>
            <input type="date" v-model="selectedDt">
            <button @click="search">검색</button>
        </div>
        <rank-table :list="list" />
    </div>
</template>

<script>
import RankTable from '../components/boxoffice/RankTable.vue';

export default {
    components: {
        RankTable
    },
    data() {
        return {
            title: 'DAILY BOX-OFFICE',
            selectedDt: '',
            list: [],
        }
    },
    methods: {
        search() {
            const targetDt = this.selectedDt.replaceAll('-', '');
            this.getData(targetDt);
        },
        async getData(targetDt) {
            const data = await this.getBoxOfficeByDay(targetDt);
            this.list = data.boxOfficeResult.dailyBoxOfficeList;
        }
    },
    created() {
        const d = new Date();
        d.setDate(d.getDate() - 1);
        this.selectedDt = this.getOnlyDateStr(d);
    }
}
</script>

<style scoped>

</style>