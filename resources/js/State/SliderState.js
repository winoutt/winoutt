import State from './State'

export default {
  collectCanShow () {
    return State.store.getters['slider/canShow']
  },
  collectPhotos () {
    return State.store.getters['slider/photos']
  },
  replaceCanShow (canShow) {
    State.store.commit('slider/replaceCanShow', canShow)
  },
  replacePhotos (photos) {
    State.store.commit('slider/replacePhotos', photos)
  },
  pullPhotos () {
    State.store.commit('slider/pullPhotos')
  }
}
