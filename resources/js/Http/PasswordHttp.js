import Http from './Http'

export default {
  reset (data) {
    return Http.post('passwords/reset', data)
  },

  update (data) {
    return Http.patch('passwords/update', data)
  },

  change (data) {
    return Http.put('passwords', data)
  }
}
