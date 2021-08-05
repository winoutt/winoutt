import { find, findIndex, some, isEmpty, orderBy } from 'lodash'

export default {
  namespaced: true,
  state: {
    notes: [],
    archived: [],
    activeNote: '',
    tab: 'notes',
    active: false
  },

  mutations: {
    addNote (state, note) {
      const notes = state.notes
      notes.unshift(note)
      state.notes = orderBy(notes, ['created_at'], ['desc'])
    },
    addArchived (state, note) {
      const archived = state.archived
      archived.unshift(note)
      state.archived = orderBy(archived, ['created_at'], ['desc'])
    },
    replaceNotes (state, notes) {
      state.notes = notes
    },
    replaceArchived (state, notes) {
      state.archived = notes
    },
    replaceActive (state) {
      state.active = !state.active
    },
    replaceActiveNote (state, note) {
      state.activeNote = note
    },
    replaceTab (state, tab) {
      state.tab = tab
    },
    amendNote (state, note) {
      const query = { id: note.id }
      const index = findIndex(state.notes, query)
      state.notes.splice(index, 1, note)
    },
    pullNote (state, id) {
      const note = find(state.notes, { id })
      if (!note) return
      const index = findIndex(state.notes, { id })
      state.notes.splice(index, 1)
    },
    pullArchived (state, id) {
      const note = find(state.archived, { id })
      if (!note) return
      const index = findIndex(state.archived, { id })
      state.archived.splice(index, 1)
    }
  },

  getters: {
    notes: state => state.notes,
    archived: state => state.archived,
    activeNote: state => state.activeNote,
    tab: state => state.tab,
    active: state => state.active,
    hasBlankNote: state => {
      return some(state.notes, note => isEmpty(note.content))
    }
  }
}
