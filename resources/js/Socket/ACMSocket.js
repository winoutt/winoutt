import Socket from './Socket'
import PostState from '../State/PostState'

const tracker = {
  deleted: false
}

export default {
  listen: {
    deleted () {
      if (Socket.isListening(tracker, 'deleted')) return
      Socket.safeBoot()
      Socket.echo.channel('post')
        .listen('.post.deleted', data => {
          const { post_id: postId } = data
          PostState.pullPost(postId)
        })
    }
  },
  leave () {
    if (Socket.echo) {
      tracker.deleted = false
      Socket.echo.leave('post')
    }
  }
}
