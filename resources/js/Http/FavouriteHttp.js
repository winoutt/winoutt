import Http from './Http'

export default {
  create (data) {
    return Http.post('favourites', data)
  },

  paginate (nextPage = false) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get('favourites/paginate')
  },

  delete (postId) {
    return Http.delete(`favourites/${postId}`)
  }
}
