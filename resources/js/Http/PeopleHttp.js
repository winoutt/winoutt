import Http from './Http'

export default {
  mayknow () {
    return Http.get('peoples/mayknow')
  },

  paginate (nextPage) {
    const baseUrl = 'peoples/paginate'
    const url = nextPage ? `${baseUrl}/${nextPage}` : baseUrl
    return Http.get(url)
  },

  search (params) {
    return Http.get('peoples/search', params)
  }
}
