import State from './State'

export default {
  addNotification (notification) {
    State.store.commit('notifications/addNotification', notification)
  },

  collectNotifications () {
    return State.store.getters['notifications/notifications']
  },

  collectNextPage () {
    return State.store.getters['notifications/nextPage']
  },

  replaceNotifications (notifications) {
    State.store.commit('notifications/replaceNotifications', notifications)
  },

  replaceNextPage (nextPage) {
    State.store.commit('notifications/replaceNextPage', nextPage)
  },

  pushNotifications (notifications) {
    State.store.commit('notifications/pushNotifications', notifications)
  },

  markFollowed (connectionId) {
    State.store.commit('notifications/markFollowed', connectionId)
  },

  markUnfollowed (connectionId) {
    State.store.commit('notifications/markUnfollowed', connectionId)
  },

  markPostFollowed (postId) {
    State.store.commit('notifications/markPostFollowed', postId)
  },

  markPostUnfollowed (postId) {
    State.store.commit('notifications/markPostUnfollowed', postId)
  },

  incrementUnreadsCount () {
    State.store.commit('notifications/incrementUnreadsCount')
  },

  collectUnreadsCount () {
    return State.store.getters['notifications/unreadsCount']
  },

  pullUnreadsCount () {
    State.store.commit('notifications/pullUnreadsCount')
  },

  replaceConnectionRequests (notifications) {
    State.store.commit('notifications/replaceConnectionRequests', notifications)
  },

  addConnectionRequest (notification) {
    State.store.commit('notifications/addConnectionRequest', notification)
  },

  collectConnectionRequests () {
    return State.store.getters['notifications/connectionRequests']
  },

  pullNotification (id) {
    State.store.commit('notifications/pullNotification', id)
  },

  decrementUnreadsCount () {
    State.store.commit('notifications/decrementUnreadsCount')
  },

  markRead (id) {
    State.store.commit('notifications/markRead', id)
  },

  markAllRead () {
    State.store.commit('notifications/markAllRead')
  },

  replaceUnreadsCount (count) {
    State.store.commit('notifications/replaceUnreadsCount', count)
  }
}
