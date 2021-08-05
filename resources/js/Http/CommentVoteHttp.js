import Http from './Http'

export default {
  create (commentId) {
    return Http.post(`comments/${commentId}/votes`)
  },

  delete (commentId) {
    return Http.delete(`comments/${commentId}/votes`)
  }
}
