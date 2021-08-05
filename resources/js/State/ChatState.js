import State from './State'

export default {
  addActive (chat) {
    State.store.commit('chats/addActive', chat)
  },

  addArchived (chat) {
    State.store.commit('chats/addArchived', chat)
  },

  activateChat (chat) {
    State.store.commit('chats/activateChat', chat)
  },

  collectActive () {
    return State.store.getters['chats/active']
  },

  collectArchived () {
    return State.store.getters['chats/archived']
  },

  collectChat () {
    return State.store.getters['chats/chat']
  },

  collectTab () {
    return State.store.getters['chats/tab']
  },

  collectNextPage () {
    return State.store.getters['chats/nextPage']
  },

  replaceActive (chats) {
    State.store.commit('chats/replaceActive', chats)
  },

  replaceArchived (chats) {
    State.store.commit('chats/replaceArchived', chats)
  },

  replaceChat (chat) {
    State.store.commit('chats/replaceChat', chat)
  },

  replaceTab (tab) {
    State.store.commit('chats/replaceTab', tab)
  },

  replaceNextPage (nextPage) {
    State.store.commit('chats/replaceNextPage', nextPage)
  },

  pushActive (chats) {
    State.store.commit('chats/pushActive', chats)
  },

  pushArchived (chats) {
    State.store.commit('chats/pushArchived', chats)
  },

  pullActive (id) {
    State.store.commit('chats/pullActive', id)
  },

  pullArchived (id) {
    State.store.commit('chats/pullArchived', id)
  },

  readChat (id) {
    State.store.commit('chats/readChat', id)
  },

  moveToActive (id) {
    State.store.commit('chats/moveToActive', id)
  },

  pullChat () {
    State.store.commit('chats/pullChat')
  },

  replaceLastMessage (message) {
    State.store.commit('chats/replaceLastMessage', message)
  }
}
