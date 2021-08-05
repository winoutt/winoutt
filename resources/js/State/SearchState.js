import State from './State'

export default {
  collectTerm () {
    return State.store.getters['search/term']
  },

  replaceTerm (term) {
    State.store.commit('search/replaceTerm', term)
  }
}
