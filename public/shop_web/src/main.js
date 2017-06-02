import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import vueStorage from 'vue-storage'
import router from './router/index.js'

Vue.use(vueStorage);
Vue.use(VueResource);


new Vue({
  el: '#app',
    components: {
        App
    },
    router,
    template: '<app/>'
})
