import Nprogress from 'nprogress'
import AppState from '../State/AppState'

export default {
  initialize: function () {
    Nprogress.configure({
      showSpinner: false,
      parent: '#progress',
      minimum: 0.1,
      trickleRate: 0.1
    })
  },

  start: function () {
    const progress = AppState.collectProgress()
    if (!progress) Nprogress.start()
    AppState.addProgress()
  },

  end: function () {
    AppState.pullProgress()
    const progress = AppState.collectProgress()
    if (!progress) Nprogress.done()
  }
}
