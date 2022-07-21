import axios from "axios";

export default {
    data() {
        return {
            key: 'dcc86f15285854e7eff0eda6d3b5c446',
            baseUrl: 'http://www.kobis.or.kr/kobisopenapi/webservice/rest/',
            boxOfficeByDay: 'boxoffice/searchDailyBoxOfficeList.json',
            boxOfficeByWeek: 'boxoffice/searchWeeklyBoxOfficeList.json',
            

        }
    },
    methods: {
        async $api(url, parameter) {
            return (await axios.get(url, {
                params: parameter
            }).catch(e => {
                console.log(e);
            })).data;
        },

        async getBoxOfficeByDay(targetDt) {
            const parameter = {
                key: this.key,
                targetDt
            }
            const url = this.baseUrl + this.boxOfficeByDay;
            return await this.$api(url, parameter);
        },

        async getBoxOfficeByWeek(targetDt, weekGb) {
            const parameter = {
                key: this.key,
                targetDt,
                weekGb,
            }
            const url = this.baseUrl + this.boxOfficeByWeek;
            return await this.$api(url, parameter);
        },

        getOnlyDateStr(date) {
            return new Date(date).toISOString().slice(0, 10);
        },

        mkDate(date) { // YYYYMMDD 문자열을 YYYY.MM.DD로 바꿔주는 함수
            const Year = date.slice(0, 4);
            const Month = date.substr(4, 2);
            const Day = date.slice(-2);
            return `${Year}.${Month}.${Day}`;
        }
    },
}