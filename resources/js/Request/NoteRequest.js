import { isEmpty } from 'lodash'
import $ from 'jquery'
import NoteHttp from '../Http/NoteHttp'
import NoteState from '../State/NoteState'

export default {
  async list () {
    const notes = await NoteHttp.list()
    if (isEmpty(notes)) return
    NoteState.replaceNotes(notes)
    return notes
  },

  async archived () {
    const notes = await NoteHttp.archived()
    if (isEmpty(notes)) return
    NoteState.replaceArchived(notes)
    return notes
  },

  async create (data) {
    const note = await NoteHttp.create(data)
    if (isEmpty(note)) return
    NoteState.addNote(note)
    NoteState.replaceTab('notes')
    NoteState.replaceActiveNote(note)
    setTimeout(() => {
      $(`#note-content-${note.id}`).focus()
    }, 0)
  },

  async edit (id, data) {
    const note = await NoteHttp.edit(id, data)
    if (isEmpty(note)) return note
    NoteState.amendNote(note)
    return note
  },

  async archive (note) {
    const id = note.id
    const { isArchived } = await NoteHttp.archive(id)
    if (!isArchived) return
    NoteState.pullNote(id)
    NoteState.addArchived(note)
  },

  async unarchive (note) {
    const id = note.id
    const { isUnarchived } = await NoteHttp.unarchive(id)
    if (!isUnarchived) return
    NoteState.pullArchived(id)
    NoteState.addNote(note)
  },

  async delete (id) {
    const { isDeleted } = await NoteHttp.delete(id)
    if (!isDeleted) return
    NoteState.pullNote(id)
  },

  async deleteBlanks () {
    await NoteHttp.deleteBlanks()
  }
}
