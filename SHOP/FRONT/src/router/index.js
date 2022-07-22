import { createRouter, createWebHistory } from 'vue-router'
import ProductList from '../views/ProductList'
import ProductDetail from '../views/ProductDetail'
import ProductCreate from '../views/ProductCreate'
import ProductUpdate from '../views/ProductUpdate'
import SalesList from '../views/SalesList'
import ImageInsert from '../views/ImageInsert'
import store from '@/store'
import swal from 'sweetalert2'

// 내비게이션 가드
const requireAuth = () => (to, from, next) => {
  if(store.state.user.iuser === undefined) {
    swal.fire('로그인을 하세요.', '', 'warning');
    return;
  }
  return next();
}
const routes = [
  {
    path: '/',
    name: 'Home',
    component: ProductList
  },
  {
    path: '/detail',
    name: 'detail',
    component: ProductDetail
  },
  {
    path: '/create',
    name: 'create',
    component: ProductCreate,
    beforeEnter: requireAuth()
  },
  {
    path: '/update',
    name: 'update',
    component: ProductUpdate
  },
  {
    path: '/sales',
    name: 'sales',
    component: SalesList
  },
  {
    path: '/imageInsert',
    name: 'imageInsert',
    component: ImageInsert,
    beforeEnter: requireAuth()
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
