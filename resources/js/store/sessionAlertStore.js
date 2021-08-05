export default {
  namespaced: true,
  state: {
    interval: null,
    time: 0
  },

  mutations: {
    replaceInterval (state, interval) {
      state.interval = interval
    },
    incrementTime (state) {
      state.time += 20
    },
    pullInterval (state) {
      state.interval = null
    },
    pullTime (state) {
      state.time = 0
    }
  },

  getters: {
    interval: state => state.interval,
    time: state => state.time
  }
}
