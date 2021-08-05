import { isEmpty } from 'lodash'
import CommentHttp from '../Http/CommentHttp'
import PostState from '../State/PostState'

export default {
  async create (data) {
    const comment = await CommentHttp.create(data)
    if (isEmpty(comment)) return
    PostState.addComment(comment)
  },

  async delete (id) {
    const response = await CommentHttp.delete(id)
    const { isDeleted } = response
    if (!isDeleted) return
    PostState.pullComment(id)
    return response
  },

  async paginate (data, nextPage = false) {
    if (nextPage === null) return
    const comments = await CommentHttp.paginate(data, nextPage)
    if (isEmpty(comments)) return
    if (nextPage) PostState.pushComments(data.postId, comments.data)
    else PostState.replaceComments(data.postId, comments.data)
    PostState.replaceCommentNextPage(data.postId, comments.next_page_url)
    return comments
  }
}
