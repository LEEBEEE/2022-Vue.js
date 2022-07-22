import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import mixins from './mixins'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


createApp(App)
.mixin(mixins)
.use(router)
.use(store)
.use(VueSweetalert2)
.mount('#app');

window.Kakao.init('97dbc5b16f12bea3a15ce13ec7a3b37a');