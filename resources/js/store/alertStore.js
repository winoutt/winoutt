export default {
  namespaced: true,
  state: {
    alert: {
      type: '',
      message: ''
    },
    action: {
      buttonText: '',
      handler: ''
    },
    watcher: null,
    timeout: 8000
  },

  mutations: {
    replaceAlert (state, alert) {
      state.alert = alert
    },
    replaceAction (state, action) {
      state.action = action
    },
    pullAlert (state) {
      state.alert = {}
    },
    pullAction (state) {
      state.action = {}
    },
    replaceTimeout (state, timeout) {
      state.timeout = timeout * 1000
    }
  },

  actions: {
    autoPull (context) {
      if (this.watcher) clearTimeout(this.watcher)
      this.watcher = setTimeout(() => {
        context.commit('pullAlert')
        context.state.timeout = 8000 // Reset
      }, context.state.timeout)
    }
  },

  getters: {
    alert: state => state.alert,
    action: state => state.action
  }
}
