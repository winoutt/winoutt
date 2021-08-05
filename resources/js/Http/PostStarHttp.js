import Http from './Http'

export default {
  paginate (postId, nextPage = false) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get(`posts/${postId}/stars`)
  }
}
