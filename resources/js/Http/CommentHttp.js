import Http from './Http'

export default {
  create (data) {
    return Http.post('comments', data)
  },

  delete (id) {
    return Http.delete(`comments/${id}`)
  },

  paginate (data, nextPage = null) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get(`comments/${data.postId}/paginate`)
  }
}
