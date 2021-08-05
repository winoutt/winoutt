import Scroll from './Scroll'
import CommentRequest from '../Request/CommentRequest'
import PostState from '../State/PostState'

const config = {
  wrapper: postId => `#comments-${postId}-wrapper`,
  content: postId => `#comments-${postId}`
}

export default {
  paginate: {
    listen (postId) {
      Scroll.onBottom(config.wrapper(postId), config.content(postId), () => {
        const nextPage = PostState.collectCommentNextPage(postId)
        const data = { postId }
        CommentRequest.paginate(data, nextPage)
      })
    },
    leave (postId) {
      Scroll.destroy(config.wrapper(postId))
    }
  }
}
