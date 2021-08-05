import State from './State'

export default {
  collectToken () {
    return State.store.getters['auth/token']
  },

  replaceToken (token) {
    return State.store.commit('auth/replaceToken', token)
  },

  pullToken () {
    return State.store.commit('auth/pullToken')
  }
}
