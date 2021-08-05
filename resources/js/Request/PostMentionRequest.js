import { isEmpty } from 'lodash'
import PostMentionHttp from '../Http/PostMentionHttp'
import UserState from '../State/UserState'

export default {
  async suggestions () {
    const suggestions = await PostMentionHttp.suggestions()
    if (isEmpty(suggestions)) UserState.replacePostMentions([])
    else UserState.replacePostMentions(suggestions)
  },

  async searchSuggestions (term) {
    const suggestions = await PostMentionHttp.searchSuggestions(term)
    if (isEmpty(suggestions)) UserState.replacePostMentions([])
    else UserState.replacePostMentions(suggestions)
  }
}
