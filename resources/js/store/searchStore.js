export default {
  namespaced: true,
  state: {
    term: ''
  },

  mutations: {
    replaceTerm (state, term) {
      state.term = term
    }
  },

  getters: {
    term: state => state.term
  }
}
