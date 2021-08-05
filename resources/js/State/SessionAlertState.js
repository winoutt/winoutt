import State from './State'

export default {
  collectInterval () {
    return State.store.getters['sessionAlert/interval']
  },

  collectTime () {
    return State.store.getters['sessionAlert/time']
  },

  replaceInterval (interval) {
    State.store.commit('sessionAlert/replaceInterval', interval)
  },

  incrementTime () {
    State.store.commit('sessionAlert/incrementTime')
  },

  pullInterval () {
    State.store.commit('sessionAlert/pullInterval')
  },

  pullTime () {
    State.store.commit('sessionAlert/pullTime')
  }
}
