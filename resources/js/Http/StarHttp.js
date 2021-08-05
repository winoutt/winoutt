import Http from './Http'

export default {
  create (data) {
    return Http.post('stars', data)
  },

  delete (data) {
    return Http.delete(`stars/${data.postId}`)
  }
}
