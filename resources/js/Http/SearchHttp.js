import Http from './Http'

export default {
  all (params) {
    return Http.get('search/all', params)
  }
}
