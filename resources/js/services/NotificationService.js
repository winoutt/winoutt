import { includes } from 'lodash'

export default {
  isPostFollowable (notification) {
    const unfollowable = [
      'star',
      'comment',
      'post_mention',
      'comment_mention',
      'comment_starred_post',
      'comment_commented_post',
      'comment_vote'
    ]
    return includes(unfollowable, notification.type)
  },

  canUnfollowPost (notification) {
    return this.isPostFollowable(notification) &&
      !notification.is_post_unfollowed
  },

  canFollowPost (notification) {
    return this.isPostFollowable(notification) && notification.is_post_unfollowed
  },

  getPostId (notification) {
    const isType = type => (notification.type === type)
    const hasPostId = includes([
      'star',
      'comment',
      'post_mention',
      'comment_starred_post',
      'comment_commented_post',
      'comment_vote'
    ], notification.type)
    return hasPostId
      ? notification.notifiable.post_id
      : isType('comment_mention')
        ? notification.notifiable.comment.post_id
        : isType('post_create')
          ? notification.notifiable.id
          : null
  }
}
