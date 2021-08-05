import Http from './Http'

export default {
  read (username) {
    return Http.get(`users/${username}`)
  },

  edit (data) {
    return Http.put('users', data)
  },

  delete (data) {
    return Http.post('users', data)
  },

  posts (username, nextPage = null) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get(`users/${username}/posts`)
  }
}
