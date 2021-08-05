import Http from './Http'

export default {
  suggestions (postId) {
    return Http.get('comments/mentions/suggestions', { post: postId })
  },

  searchSuggestions (postId, term) {
    const params = { post: postId, term }
    return Http.get('comments/mentions/suggestions/search', params)
  }
}
