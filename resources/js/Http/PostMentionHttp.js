import Http from './Http'

export default {
  suggestions () {
    return Http.get('posts/mentions/suggestions')
  },

  searchSuggestions (term) {
    return Http.get('posts/mentions/suggestions/search', { term })
  }
}
