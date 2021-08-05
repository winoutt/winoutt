import Http from './Http'

export default {
  create (data) {
    return Http.post('unfollows', data)
  },

  delete (connectionId) {
    return Http.delete(`unfollows/${connectionId}`)
  }
}
