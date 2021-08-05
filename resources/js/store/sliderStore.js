export default {
  namespaced: true,
  state: {
    canShow: false,
    photos: []
  },

  mutations: {
    replaceCanShow (state, canShow) {
      state.canShow = canShow
    },
    replacePhotos (state, photos) {
      state.photos = photos
    },
    pullPhotos (state) {
      state.photos = []
    }
  },

  getters: {
    canShow: state => state.canShow,
    photos: state => state.photos
  }
}
