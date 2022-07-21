<!-- BoxOfficeByDay.vue / BoxOfficeByWeek.vue 합치기 -->
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
            title: '',
            selectedDt: '',
            list: [],
            showRange: '',
            yearWeekTime: '',
            pathName: ''
        }
    },
    methods: {
        search() {
            const targetDt = this.selectedDt.replaceAll('-', '');
            this.getData(targetDt);
        },
        async getData(targetDt) {

            this.pathName = this.$route.name;
            switch(this.pathName) {
                case 'boxOfficeByDay':
                    this.list = (await this.getBoxOfficeByDay(targetDt))
                                .boxOfficeResult.dailyBoxOfficeList;
                    this.showRange = '';
                    this.yearWeekTime = '';
                    break;
                case 'boxOfficeByWeek':
                    const data = await this.getBoxOfficeByWeek(targetDt, 0);
                    this.list = data.boxOfficeResult.weeklyBoxOfficeList;
                    const range = data.boxOfficeResult.showRange.split('~');
                    this.showRange = this.mkDate(range[0]) + '~' + this.mkDate(range[1]);
                    this.yearWeekTime = data.boxOfficeResult.yearWeekTime.slice(-2) + '주 차';
                    break;
            }
        }
    },
    created() {
        const d = new Date();
        this.pathName = this.$route.name;
        switch(this.pathName) {
            case 'boxOfficeByDay':
                d.setDate(d.getDate() - 1);
                this.title = 'DAILY BOXOFFICE';
                this.selectedDt = this.getOnlyDateStr(d);
                break;
            case 'boxOfficeByWeek':
                d.setDate(d.getDate() - 7);
                this.title = 'WEEKLY BOXOFFICE';
                this.selectedDt = this.getOnlyDateStr(d);
                break;
        }
    },
    updated() {
        // const d = new Date();
        this.pathName = this.$route.name;
        switch(this.pathName) {
            case 'boxOfficeByDay':
                // d.setDate(d.getDate() - 1);
                // this.selectedDt = this.getOnlyDateStr(d);
                this.title = 'DAILY BOXOFFICE';
                break;
            case 'boxOfficeByWeek':
                // d.setDate(d.getDate() - 7);
                // this.selectedDt = this.getOnlyDateStr(d);
                this.title = 'WEEKLY BOXOFFICE';
                break;
        }
    },
}

</script>

<style scoped>
    .m-2 { margin: 2rem; }
</style>