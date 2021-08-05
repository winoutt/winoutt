import { isEmpty } from 'lodash'
import CommentVoteHttp from '../Http/CommentVoteHttp'
import PostState from '../State/PostState'
import AuthToken from '../services/AuthToken'
import IntendedRedirect from '../services/IntendedRedirect'

export default {
  async create (comment) {
    if (!AuthToken.has()) return IntendedRedirect.post(comment.post_id)
    const response = await CommentVoteHttp.create(comment.id)
    if (isEmpty(response)) return
    PostState.upvoteComment(comment)
    return response
  },

  async delete (comment) {
    const response = await CommentVoteHttp.delete(comment.id)
    if (isEmpty(response)) return
    PostState.unvoteComment(comment)
    return response
  }
}
