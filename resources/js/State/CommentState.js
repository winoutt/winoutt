import State from './State'

export default {
  replaceComment (comment) {
    State.store.commit('comment/replaceComment', comment)
  },
  collectComment () {
    return State.store.getters['comment/comment']
  }
}
