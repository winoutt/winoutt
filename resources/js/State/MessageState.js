import State from './State'

export default {
  addMessage (message) {
    State.store.commit('messages/addMessage', message)
  },

  collectMessages () {
    return State.store.getters['messages/messages']
  },

  collectNextPage () {
    return State.store.getters['messages/nextPage']
  },

  replaceMessages (messages) {
    State.store.commit('messages/replaceMessages', messages)
  },

  replaceNextPage (nextPage) {
    State.store.commit('messages/replaceNextPage', nextPage)
  },

  pushMessages (messages) {
    State.store.commit('messages/pushMessages', messages)
  },

  readMessages (chatId) {
    State.store.commit('messages/readMessages', chatId)
  },

  deliveredMessage (id) {
    State.store.commit('messages/deliveredMessage', id)
  },

  readMessage (id) {
    State.store.commit('messages/readMessage', id)
  },

  replaceUnreadsCount (count) {
    State.store.commit('messages/replaceUnreadsCount', count)
  },

  addUnreadsCount (count) {
    State.store.commit('messages/addUnreadsCount', count)
  },

  pullUnreadsCount (count) {
    State.store.commit('messages/pullUnreadsCount', count)
  },

  collectUnreadsCount () {
    return State.store.getters['messages/unreadsCount']
  },

  pullMessages () {
    State.store.commit('messages/pullMessages')
  }
}
