import { forEach, find, findIndex, compact, isEmpty } from 'lodash'

export default {
  namespaced: true,
  state: {
    active: [],
    archived: [],
    chat: {},
    tab: 'active',
    nextPage: ''
  },

  mutations: {
    addActive (state, chat) {
      state.active.unshift(chat)
    },
    addArchived (state, chat) {
      state.archived.unshift(chat)
    },
    activateChat (state, chat) {
      const { id } = chat
      const activeChat = find(state.active, { id })
      const archivedChat = find(state.archived, { id })
      if (activeChat) {
        this.commit('chats/pullActive', chat.id)
        this.commit('chats/addActive', chat)
        this.commit('chats/replaceTab', 'active')
      } else if (archivedChat) {
        this.commit('chats/pullArchived', chat.id)
        this.commit('chats/addArchived', chat)
        this.commit('chats/replaceTab', 'archived')
      } else {
        const { is_archived: isArchived } = chat
        if (isArchived) {
          this.commit('chats/addArchived', chat)
          this.commit('chats/replaceTab', 'archived')
        } else {
          this.commit('chats/addActive', chat)
          this.commit('chats/replaceTab', 'active')
        }
      }
      this.commit('chats/replaceChat', chat)
    },
    replaceActive (state, chats) {
      state.active = chats
    },
    replaceArchived (state, chats) {
      state.archived = chats
    },
    replaceChat (state, chat) {
      state.chat = chat
    },
    replaceTab (state, tab) {
      state.tab = tab
    },
    replaceNextPage (state, nextPage) {
      state.nextPage = nextPage
    },
    pushActive (state, chats) {
      forEach(chats, chat => {
        state.active.push(chat)
      })
    },
    pushArchived (state, chats) {
      forEach(chats, chat => {
        state.archived.push(chat)
      })
    },
    pullActive (state, id) {
      const existingChat = find(state.active, { id })
      if (!existingChat) return
      const index = findIndex(state.active, { id })
      state.active.splice(index, 1)
    },
    pullArchived (state, id) {
      const existingChat = find(state.archived, { id })
      if (!existingChat) return
      const index = findIndex(state.archived, { id })
      state.archived.splice(index, 1)
    },
    readChat (state, id) {
      const active = find(state.active, { pivot: { id } })
      const archived = find(state.archived, { pivot: { id } })
      const isActive = !isEmpty(active)
      const chat = active || archived
      if (!chat) return
      if (isActive) this.commit('messages/pullUnreadsCount', chat.unreads_count)
      chat.unreads_count = 0
    },
    moveToActive (state, id) {
      const chat = find(state.archived, { pivot: { id } })
      if (!chat) return
      this.commit('chats/pullArchived', chat.id)
      this.commit('chats/addActive', chat)
    },
    increaseUnreadsCount (state, id) {
      const active = find(state.active, { pivot: { id } })
      const archived = find(state.archived, { pivot: { id } })
      const chats = compact([active, archived])
      forEach(chats, chat => chat.unreads_count++)
    },
    pullChat (state) {
      state.chat = {}
    },
    replaceLastMessage (state, message) {
      const active = find(state.active, { pivot: { id: message.chat_id } })
      const archived = find(state.archived, { pivot: { id: message.chat_id } })
      const chats = compact([active, archived])
      forEach(chats, chat => { chat.last_message = message })
    },
    moveActiveTop (state, id) {
      const chat = find(state.active, { pivot: { id } })
      if (isEmpty(chat)) return
      this.commit('chats/pullActive', chat.id)
      this.commit('chats/addActive', chat)
    }
  },

  getters: {
    active: state => state.active,
    archived: state => state.archived,
    chat: state => state.chat,
    tab: state => state.tab,
    nextPage: state => state.nextPage
  }
}
