import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue';
// import BoxOfficeByDay from '../views/BoxOfficeByDay.vue';
// import BoxOfficeByWeek from '../views/BoxOfficeByWeek.vue';
import BoxOffice from '../views/BoxOffice.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/boxOfficeByDay',
    name: 'boxOfficeByDay',
    component: BoxOffice
  },
  {
    path: '/boxOfficeByWeek',
    name: 'boxOfficeByWeek',
    component: BoxOffice
  },
  
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
