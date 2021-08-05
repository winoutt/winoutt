import State from './State'

export default {
  collectUser () {
    return State.store.getters['users/user']
  },

  collectProfile () {
    return State.store.getters['users/profile']
  },

  collectModal () {
    return State.store.getters['users/modal']
  },

  collectUsers () {
    return State.store.getters['users/users']
  },

  collectSearch (reference) {
    return State.store.getters['users/search'](reference)
  },

  collectMutuals () {
    return State.store.getters['users/mutuals']
  },

  collectMutualsModal () {
    return State.store.getters['users/mutualsModal']
  },

  collectConnections () {
    return State.store.getters['users/connections']
  },

  collectConnectionsModal () {
    return State.store.getters['users/connectionsModal']
  },

  collectConnectionRequestModal () {
    return State.store.getters['users/connectionRequestModal']
  },

  collectPostStarsNextPage () {
    return State.store.getters['users/postStarsNextPage']
  },

  replaceUser (user) {
    State.store.commit('users/replaceUser', user)
  },

  replaceProfile (profile) {
    State.store.commit('users/replaceProfile', profile)
  },

  replaceModal (user) {
    State.store.commit('users/replaceModal', user)
  },

  replaceMutualsModal (user) {
    State.store.commit('users/replaceMutualsModal', user)
  },

  replaceConnectionsModal (user) {
    State.store.commit('users/replaceConnectionsModal', user)
  },

  replaceUsers (users) {
    State.store.commit('users/replaceUsers', users)
  },

  replaceSearch (reference, users) {
    const payload = { reference, users }
    State.store.commit('users/replaceSearch', payload)
  },

  replaceMutuals (mutuals) {
    State.store.commit('users/replaceMutuals', mutuals)
  },

  replaceConnections (connections) {
    State.store.commit('users/replaceConnections', connections)
  },

  replaceConnectionRequestModal (user) {
    State.store.commit('users/replaceConnectionRequestModal', user)
  },

  replaceNextPage (nextPage) {
    State.store.commit('users/replaceNextPage', nextPage)
  },

  pushUsers (users) {
    State.store.commit('users/pushUsers', users)
  },

  pullUser () {
    State.store.commit('users/pullUser')
  },

  markRequested (id) {
    State.store.commit('users/markRequested', id)
  },

  markAccepted (id) {
    State.store.commit('users/markAccepted', id)
  },

  markIgnored (id) {
    State.store.commit('users/markIgnored', id)
  },

  markDisconnected (id) {
    State.store.commit('users/markDisconnected', id)
  },

  markCanceled (id) {
    State.store.commit('users/markCanceled', id)
  },

  incrementPostsCount (id) {
    State.store.commit('users/incrementPostsCount', id)
  },

  decrementPostsCount (id) {
    State.store.commit('users/decrementPostsCount', id)
  },

  collectIsProfileCompleted () {
    return State.store.getters['users/collectIsProfileCompleted']
  },

  markFollowed (id) {
    State.store.commit('users/markFollowed', id)
  },

  markUnfollowed (id) {
    State.store.commit('users/markUnfollowed', id)
  },

  pushPostStars (stars) {
    State.store.commit('users/pushPostStars', stars)
  },

  replacePostStars (stars) {
    State.store.commit('users/replacePostStars', stars)
  },

  collectPostStars () {
    return State.store.getters['users/postStars']
  },

  updateStatus (id, isOnline) {
    const payload = { id, isOnline }
    return State.store.commit('users/updateStatus', payload)
  },

  pushMutuals (mutuals) {
    State.store.commit('users/pushMutuals', mutuals)
  },

  pushConnections (connections) {
    State.store.commit('users/pushConnections', connections)
  },

  replacePostMentions (suggestions) {
    State.store.commit('users/replacePostMentions', suggestions)
  },

  collectPostMentions () {
    return State.store.getters['users/postMentions']
  },

  replaceCommentMentions (postId, suggestions) {
    const payload = { postId, suggestions }
    State.store.commit('users/replaceCommentMentions', payload)
  },

  collectCommentMentions () {
    return State.store.getters['users/commentMentions']
  }
}
