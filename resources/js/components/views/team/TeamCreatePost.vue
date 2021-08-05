<template lang="pug">
  .col-144
    .team-create-post.d-flex.align-items-center.bg-white.border
      AvatarSmall.mr-2(:user="user" v-if="hasAuth")
      ButtonOutlineLarge.button.m-auto.px-4.w-100(
        text="Create a New Post"
        mobile-text="New post"
        icon="add"
        @click.native="openModal"
      )
      PostCreateModal
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../../services/ModalServices/PostModalService'
import UserState from '../../../State/UserState'

import AvatarSmall from '../../avatar/AvatarSmall.vue'
import ButtonOutlineLarge from '../../button/ButtonOutlineLarge.vue'
import PostCreateModal from '../../post/PostCreateModal.vue'
import AuthToken from '../../../services/AuthToken'
import IntendedRedirect from '../../../services/IntendedRedirect'

export default Vue.extend({
  components: {
    AvatarSmall,
    ButtonOutlineLarge,
    PostCreateModal
  },

  computed: {
    hasAuth () {
      return AuthToken.has()
    },
    user () {
      return UserState.collectUser()
    }
  },

  methods: {
    openModal () {
      if (!this.hasAuth) return IntendedRedirect.redirect(this.$route.path)
      PostModalService.create().open()
    }
  }
})
</script>

<style lang="sass" scoped>
.team-create-post
  margin-bottom: 0.725rem
  border-radius: 3px
  padding: 8px 25px
</style>
