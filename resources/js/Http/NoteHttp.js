import Http from './Http'

export default {
  list () {
    return Http.get('notes')
  },

  archived () {
    return Http.get('notes/archived')
  },

  create (data) {
    return Http.post('notes', data)
  },

  edit (id, data) {
    return Http.put(`notes/${id}`, data)
  },

  archive (id) {
    return Http.delete(`notes/${id}/archive`)
  },

  unarchive (id) {
    return Http.post(`notes/${id}/unarchive`)
  },

  delete (id) {
    return Http.delete(`notes/${id}`)
  },

  deleteBlanks () {
    return Http.delete('notes/blanks')
  }
}
