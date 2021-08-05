import State from './State'

export default {
  collectHashtags () {
    return State.store.getters['hashtags/hashtags']
  },

  collectSearch () {
    return State.store.getters['hashtags/search']
  },

  collectNextPage () {
    return State.store.getters['hashtags/nextPage']
  },

  replaceHashtags (hashtags) {
    State.store.commit('hashtags/replaceHashtags', hashtags)
  },

  replaceSearch (hashtags) {
    State.store.commit('hashtags/replaceSearch', hashtags)
  },

  replaceNextPage (nextPage) {
    State.store.commit('hashtags/replaceNextPage', nextPage)
  }
}
