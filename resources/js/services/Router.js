import Vue from 'vue'
import { isEmpty } from 'lodash'
import VueRouter from 'vue-router'
import routes from '../routes'
import closeModalMiddleware from '../middleware/closeModalMiddleware'
import closeAlertMiddleware from '../middleware/closeAlertMiddleware'

export default {
  router: {},

  boot () {
    Vue.use(VueRouter)
    this.router = new VueRouter({
      mode: 'history',
      routes,
      scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
      }
    })
    this.router.beforeEach((to, from, next) => {
      closeModalMiddleware(to, from, next)
      closeAlertMiddleware(to, from, next)
    })
  },

  resolveHref (name, params = {}) {
    if (isEmpty(this.router)) return
    const { href } = this.router.resolve({ name, params })
    return href
  }
}
