import Http from './Http'

export default {
  login (data) {
    return Http.post('auth/login', data)
  },

  logout () {
    return Http.get('auth/logout')
  },

  register (data) {
    return Http.post('auth/register', data)
  },

  user () {
    return Http.get('auth/user')
  }
}
