import State from './State'

export default {
  addNote (note) {
    State.store.commit('notes/addNote', note)
  },

  addArchived (note) {
    State.store.commit('notes/addArchived', note)
  },

  collectNotes () {
    return State.store.getters['notes/notes']
  },

  collectArchived () {
    return State.store.getters['notes/archived']
  },

  collectActiveNote () {
    return State.store.getters['notes/activeNote']
  },

  collectTab () {
    return State.store.getters['notes/tab']
  },

  collectActive () {
    return State.store.getters['notes/active']
  },

  collectHasBlankNote () {
    return State.store.getters['notes/hasBlankNote']
  },

  replaceNotes (notes) {
    State.store.commit('notes/replaceNotes', notes)
  },

  replaceArchived (notes) {
    State.store.commit('notes/replaceArchived', notes)
  },

  replaceActive () {
    State.store.commit('notes/replaceActive')
  },

  replaceActiveNote (note) {
    State.store.commit('notes/replaceActiveNote', note)
  },

  replaceTab (tab) {
    State.store.commit('notes/replaceTab', tab)
  },

  amendNote (note) {
    State.store.commit('notes/amendNote', note)
  },

  pullNote (id) {
    State.store.commit('notes/pullNote', id)
  },

  pullArchived (id) {
    State.store.commit('notes/pullArchived', id)
  }
}
