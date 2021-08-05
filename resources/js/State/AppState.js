import State from './State'

export default {
  addProgress () {
    State.store.commit('app/addProgress')
  },

  replaceIsBooted (isBooted) {
    State.store.commit('app/replaceIsBooted', isBooted)
  },

  collectIsBooted () {
    return State.store.getters['app/isBooted']
  },

  collectProgress () {
    return State.store.getters['app/progress']
  },

  pullProgress () {
    State.store.commit('app/pullProgress')
  }
}
