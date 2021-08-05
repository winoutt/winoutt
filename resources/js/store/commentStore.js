export default {
  namespaced: true,
  state: {
    comment: {}
  },

  mutations: {
    replaceComment (state, comment) {
      state.comment = comment
    }
  },

  getters: {
    comment: state => state.comment
  }
}
