export default {
  namespaced: true,
  state: {
    token: null
  },

  mutations: {
    replaceToken (state, token) {
      state.token = token
    },
    pullToken (state) {
      state.token = null
    }
  },

  getters: {
    token: state => state.token
  }
}
