<template lang="pug">
  .comment.py-2
    .comment-head.d-flex.align-items-center
      router-link.comment-info.d-flex.text-truncate.no-hover.mr-2(
        :to="{ name: 'Profile', params: { username: comment.user.username } }"
      )
        AvatarSmall.mr-2(:user="comment.user")
        .details.d-flex.flex-column.justify-content-center.text-truncate
          .user.d-flex.flex-column
            .name.d-flex
              FullName.user-name.font-weight-bold {{ comment.user.full_name }}
              .badge.author-label.badge-primary.align-self-center(v-if="comment.is_author") Author
            JobTitle.title.text-secondary(:lineClamp="1") {{ comment.user.title }}
      .comment-actions.ml-auto.d-flex.flex-column
        Dropdown.align-self-end.mb-1(:horizontal="true")
          .dropdown-item.cursor-pointer(v-if="comment.is_user" @click="commentDelete()") Delete
          .dropdown-item.cursor-pointer(v-else @click="commentReport()") Report
        small.time.text-secondary {{ Humanize.fromNow(comment.created_at) }}
    component.comment-content(:is="{ template: Util.linkify(comment.content) }")
    CommentUpvoteButton(:comment="comment")
</template>

<script lang="ts">
import Vue from 'vue'
import CommentModalService from '../../services/ModalServices/CommentModalService'
import IntendedRedirect from '../../services/IntendedRedirect'
import CommentState from '../../State/CommentState'
import AuthToken from '../../services/AuthToken'

import AvatarSmall from '../avatar/AvatarSmall.vue'
import Dropdown from '../Dropdown.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'
import CommentUpvoteButton from './CommentUpvoteButton.vue'

export default Vue.extend({
  props: ['comment'],
  components: {
    AvatarSmall,
    Dropdown,
    FullName,
    JobTitle,
    CommentUpvoteButton
  },

  methods: {
    commentDelete () {
      CommentState.replaceComment(this.comment)
      CommentModalService.deleteConfirm().open()
    },
    commentReport () {
      if (!AuthToken.has()) return IntendedRedirect.post(this.comment.post_id)
      CommentState.replaceComment(this.comment)
      CommentModalService.report().open()
    }
  }
})
</script>

<style lang="sass" scoped>
.title
  font-size: 0.75rem
  margin-top: -2px
.comment-head
    margin-bottom: 10px
.author-label
  margin-left: 6px
.user-name
  font-size: 0.813rem
.time
  font-size: 0.75rem
  white-space: nowrap
</style>
