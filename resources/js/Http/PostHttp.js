import Http from './Http'

export default {
  create (data) {
    return Http.post('posts', data)
  },

  delete (id) {
    return Http.delete(`posts/${id}`)
  },

  read (id) {
    return Http.get(`posts/${id}`)
  },

  top () {
    return Http.get('posts/top')
  }
}
