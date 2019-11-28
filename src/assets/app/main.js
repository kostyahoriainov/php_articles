import Vue from 'vue'
import App from './App.vue'
import router from './routes'
import store from './store'
import SuiVue from 'semantic-ui-vue'

Vue.use(SuiVue);

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
