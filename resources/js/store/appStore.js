export default {
  namespaced: true,
  state: {
    isBooted: false,
    progress: 0
  },

  mutations: {
    addProgress (state) {
      state.progress = state.progress + 1
    },
    replaceIsBooted (state, isBooted) {
      state.isBooted = isBooted
    },
    pullProgress (state) {
      state.progress = state.progress - 1
    }
  },

  getters: {
    isBooted: state => state.isBooted,
    progress: state => state.progress
  }
}
