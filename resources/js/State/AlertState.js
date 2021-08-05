import State from './State'

export default {
  collectAlert () {
    return State.store.getters['alert/alert']
  },

  collectAction () {
    return State.store.getters['alert/action']
  },

  replaceAlert (alert) {
    State.store.commit('alert/pullAction')
    State.store.commit('alert/replaceAlert', alert)
    State.store.dispatch('alert/autoPull')
  },

  replaceAction (action) {
    State.store.commit('alert/replaceAction', action)
  },

  pullAlert () {
    State.store.commit('alert/pullAlert')
  },

  pullAction () {
    State.store.commit('alert/pullAction')
  },

  replaceTimeout (timeout) {
    State.store.commit('alert/replaceTimeout', timeout)
  }
}
