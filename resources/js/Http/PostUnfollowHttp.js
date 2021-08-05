import Http from './Http'

export default {
  create (postId) {
    return Http.post(`posts/${postId}/unfollows`)
  },

  delete (postId) {
    return Http.delete(`posts/${postId}/unfollows`)
  }
}
