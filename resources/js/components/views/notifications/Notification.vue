<template lang="pug">
.notification.d-flex.align-items-start.justify-content-between.border.border-top-0(
  :class="unreadClass(notification)"
  @click="markRead()"
)
  .main.d-flex.align-items-center
    router-link.no-hover(:to="{ name: 'Profile', params: { username: notification.connection.username } }")
      .avatar
        img(:src="notification.connection.avatar")
    .content
      NotificationStar(v-if="notification.type === 'star'" :notification="notification")
      NotificationAccept(v-else-if="notification.type === 'connection_accept'" :notification="notification")
      NotificationComment(v-else-if="notification.type === 'comment'" :notification="notification")
      NotificationMention(v-else-if="notification.type === 'post_mention'" :notification="notification")
      NotificationCommentMention(v-else-if="notification.type === 'comment_mention'" :notification="notification")
      NotificationPostCreate(v-else-if="notification.type === 'post_create'" :notification="notification")
      NotificationCommentStarredPost(v-else-if="notification.type === 'comment_starred_post'" :notification="notification")
      NotificationCommentCommentedPost(v-else-if="notification.type === 'comment_commented_post'" :notification="notification")
      NotificationCommentVote(v-else-if="notification.type === 'comment_vote'" :notification="notification")
  .options.d-flex.flex-column.align-items-end.justify-content-center
    Dropdown.dropdown.mb-1(:horizontal="true")
      .dropdown-item.cursor-pointer(@click="follow(notification.connection)" v-if="notification.is_unfollowed") Enable notifications from {{ notification.connection.full_name }}
      .dropdown-item.cursor-pointer(@click="unfollow(notification.connection)" v-else) Disable notifications from {{ notification.connection.full_name }}
      .dropdown-item.cursor-pointer(@click="unfollowPost(notification)" v-if="canShowUnfollowPost(notification)") Disable notifications from this post
      .dropdown-item.cursor-pointer(@click="followPost(notification)" v-if="canShowFollowPost(notification)") Enable notifications from this post
    small.time.text-secondary {{ Humanize.fromNow(notification.created_at) }}
</template>

<script lang="ts">
import Vue from 'vue'
import UnfollowRequest from '../../../Request/UnfollowRequest'
import PostUnfollowRequest from '../../../Request/PostUnfollowRequest'
import NotificationService from '../../../services/NotificationService'

import NotificationStar from './NotificationStar.vue'
import NotificationAccept from './NotificationAccept.vue'
import NotificationComment from './NotificationComment.vue'
import NotificationMention from './NotificationMention.vue'
import NotificationCommentMention from './NotificationCommentMention.vue'
import NotificationPostCreate from './NotificationPostCreate.vue'
import NotificationCommentStarredPost from './NotificationCommentStarredPost.vue'
import NotificationCommentCommentedPost from './NotificationCommentCommentedPost.vue'
import NotificationCommentVote from './NotificationCommentVote.vue'
import Dropdown from '../../Dropdown.vue'
import NotificationRequest from '../../../Request/NotificationRequest'

export default Vue.extend({
  props: ['notification'],

  components: {
    NotificationStar,
    NotificationAccept,
    NotificationComment,
    NotificationMention,
    NotificationCommentMention,
    NotificationPostCreate,
    NotificationCommentStarredPost,
    NotificationCommentCommentedPost,
    NotificationCommentVote,
    Dropdown
  },

  methods: {
    canShowUnfollowPost (notification) {
      return NotificationService.canUnfollowPost(notification)
    },
    canShowFollowPost (notification) {
      return NotificationService.canFollowPost(notification)
    },
    follow (user) {
      UnfollowRequest.delete(user.id)
    },
    unfollow (user) {
      UnfollowRequest.create(user)
    },
    followPost (notification) {
      const postId = NotificationService.getPostId(notification)
      if (!postId) return
      PostUnfollowRequest.delete(postId)
    },
    unfollowPost (notification) {
      const postId = NotificationService.getPostId(notification)
      if (!postId) return
      PostUnfollowRequest.create(postId)
    },
    unreadClass (notification) {
      const isUnread = !notification.is_read
      return { 'px-3 unread': isUnread }
    },
    markRead () {
      if (this.notification.is_read) return
      NotificationRequest.markRead(this.notification)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../../sass/variables'

.notification
  padding: 10px 15px
  background: #fff
  .avatar img
    width: 37px
    height: 37px
    object-fit: contain
    border-radius: 50%
    margin-right: 11px
  .content
    font-size: 0.875rem
  &.unread
    background: #ebedf6
  .dropdown
    margin-top: 8px
  .time
    font-size: 0.75rem
    white-space: nowrap
</style>
