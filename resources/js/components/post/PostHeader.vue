<template lang="pug">
  .post-header.mb-4
    .post-info.d-flex.align-items-center.mb-3
      router-link.post-details.d-flex.text-truncate.mr-2.no-hover(
        :to="{ name: 'Profile', params: { username: post.user.username } }"
      )
        AvatarMedium.avatar(:user="post.user" :size="47")
        .user.d-flex.flex-column.justify-content-center.text-truncate
          FullName.name.font-weight-bold {{ post.user.full_name }}
          JobTitle.title.text-secondary(:lineClamp="1") {{ post.user.title }}
      .post-actions.ml-auto.d-flex.flex-column
        Dropdown.align-self-end.mb-1(:horizontal="true")
          .dropdown-item.cursor-pointer(
            @click="postDelete()"
            v-if="post.is_user"
          ) Delete
          .dropdown-item.cursor-pointer(@click="postReport()" v-if="post.user.id !== user.id") Report
        small.time.text-secondary.text-nowrap {{ Humanize.fromNow(post.created_at) }}
    PostLinkPreview(:post="post" position='top')
    .caption
      ReadMore(:text="post.caption" :maxChars="250" :previewLink="linkPreviewUrl")
    PostLinkPreview(:post="post" position='bottom')
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import PostState from '../../State/PostState'
import UserState from '../../State/UserState'
import AuthToken from '../../services/AuthToken'
import IntendedRedirect from '../../services/IntendedRedirect'

import AvatarMedium from '../avatar/AvatarMedium.vue'
import Dropdown from '../Dropdown.vue'
import ReadMore from '../ReadMore.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'
import PostLinkPreview from './PostLinkPreview.vue'

export default Vue.extend({
  props: ['post'],
  components: {
    AvatarMedium,
    Dropdown,
    ReadMore,
    FullName,
    JobTitle,
    PostLinkPreview
  },

  computed: {
    user () {
      return UserState.collectUser()
    },
    linkPreviewUrl () {
      const linkPreview = this.post.link_preview
      return linkPreview ? linkPreview.url : null
    }
  },

  methods: {
    postDelete () {
      PostState.replacePost(this.post)
      PostModalService.deleteConfirm().open()
    },
    postReport () {
      if (!AuthToken.has()) return IntendedRedirect.post(this.post.id)
      PostState.replacePost(this.post)
      PostModalService.report().open()
    }
  }
})
</script>

<style lang="sass" scoped>
.post-header
  .post-info
    .avatar
      margin-right: 0.6rem
    .user
      .name
        margin-bottom: -4px
      .title
        font-size: 0.85rem
  .post-actions
    margin-top: 7px
    .time
      font-size: 0.75rem
</style>
