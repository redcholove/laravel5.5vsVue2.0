import Vue from 'vue'
import Router from 'vue-router'
import Login from './../components/Login.vue'
import ChatRoom from './../components/ChatRoom.vue'
import SingleChat from './../components/SingleChat.vue'
Vue.use(Router)

export default new Router({
  routes: [
    {
        path: '/',
        name: 'home',
        component: Login
    },
      {
      path: '/buysale',
      name: 'ChatRoom',
      component: ChatRoom
    },
      {
        path: '/addnew',
        name: 'SingleChat',
        component: SingleChat
    }
  ]
})

