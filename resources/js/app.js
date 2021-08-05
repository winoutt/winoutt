import Popper from 'popper.js' // eslint-disable-line
import bootstrap from 'bootstrap' // eslint-disable-line
import App from './App.vue'
import Vue from 'vue'
import Router from './services/Router'
import State from './State/State'
import UtilsPlugin from './Plugin/UtilsPlugin'
import HumanizePlugin from './Plugin/HumanizePlugin'

Router.boot()
State.boot()

Vue.use(UtilsPlugin)
Vue.use(HumanizePlugin)

// eslint-disable-next-line
new Vue({
  el: '#app',
  router: Router.router,
  render: h => h(App)
})
