<template>
      <div>
        <h1>{{ title }}</h1>
        <div class="m-2">
            <input type="date" v-model="selectedDt">
            <button @click="search">검색</button>
        </div>
        <div>
            <h4>{{ showRange }}</h4>
            <h4>{{ yearWeekTime }}</h4>
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
            title: 'WEEKLY BOX-OFFICE',
            selectedDt: '',
            list: [],
            showRange: '',
            yearWeekTime: '',
        }
    },
    methods: {
        search() {
            const targetDt = this.selectedDt.replaceAll('-', '');
            this.getData(targetDt);
        },
        async getData(targetDt) {
            const data = await this.getBoxOfficeByWeek(targetDt, 0);
            console.log(data);
            this.list = data.boxOfficeResult.weeklyBoxOfficeList;
            const range = data.boxOfficeResult.showRange.split('~');
            this.showRange = this.mkDate(range[0]) + '~' + this.mkDate(range[1]);
            this.yearWeekTime = data.boxOfficeResult.yearWeekTime.slice(-2) + '주 차';
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
    .m-2 { margin: 2rem; }
</style>