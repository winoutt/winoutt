import { isEmpty } from 'lodash'
import CommentMentionHttp from '../Http/CommentMentionHttp'
import UserState from '../State/UserState'

export default {
  async suggestions (postId) {
    const suggestions = await CommentMentionHttp.suggestions(postId)
    if (isEmpty(suggestions)) UserState.replaceCommentMentions(postId, [])
    else UserState.replaceCommentMentions(postId, suggestions)
  },

  async searchSuggestions (postId, term) {
    const suggestions = await CommentMentionHttp.searchSuggestions(postId, term)
    if (isEmpty(suggestions)) UserState.replaceCommentMentions(postId, [])
    else UserState.replaceCommentMentions(postId, suggestions)
  }
}
