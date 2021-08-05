import { isEmpty } from 'lodash'
import PostUnfollowHttp from '../Http/PostUnfollowHttp'
import NotificationState from '../State/NotificationState'
import Alert from '../services/Alert'

const PostUnfollowRequest = {
  async create (postId) {
    const post = await PostUnfollowHttp.create(postId)
    if (isEmpty(post)) return
    NotificationState.markPostUnfollowed(postId)
    const alertMessage = 'You will no longer receive notifications from this post'
    Alert.action.success(alertMessage, 'Undo', function () {
      PostUnfollowRequest.delete(postId)
    })
  },

  async delete (postId) {
    const post = await PostUnfollowHttp.delete(postId)
    if (isEmpty(post)) return
    NotificationState.markPostFollowed(postId)
    Alert.success('Successfully followed the post')
  }
}

export default PostUnfollowRequest
