import Http from './Http'

export default {
  create (data) {
    return Http.post('connections', data)
  },

  accept (id) {
    return Http.post(`connections/${id}/accept`)
  },

  ignore (id) {
    return Http.post(`connections/${id}/ignore`)
  },

  mutuals (id, nextPage = null) {
    const baseUrl = `connections/${id}/mutuals?page=1`
    const url = nextPage || baseUrl
    return Http.get(url)
  },

  list (id, nextPage = null) {
    const baseUrl = `connections/${id}?page=1`
    const url = nextPage || baseUrl
    return Http.get(url)
  },

  disconnect (id) {
    return Http.post(`connections/${id}/disconnect`)
  },

  cancel (id) {
    return Http.post(`connections/${id}/cancel`)
  }
}
