export default {
  namespaced: true,
  state: {
    hashtags: [],
    search: []
  },

  mutations: {
    replaceHashtags (state, hashtags) {
      state.hashtags = hashtags
    },
    replaceSearch (state, hashtags) {
      state.search = hashtags
    }
  },

  getters: {
    hashtags: state => state.hashtags,
    search: state => state.search
  }
}
