<template lang="pug">
  .comment-mentionbox.position-absolute.border.rounded.bg-white.shadow(
    v-if="canShowMentionBox"
  )
    .people.py-2.scroll
      .user.d-flex.align-items-center.px-3.py-2.cursor-pointer(
        v-for="user in users"
        @click="choose(user)"
      )
        AvatarSmall.mr-2(:user="user")
        .user-details.text-truncate
          FullName.name {{ user.full_name }}
          JobTitle.title {{ user.title }}
</template>

<script lang="ts">
import Vue from 'vue'
import { size } from 'lodash'

import AvatarSmall from '../avatar/AvatarSmall.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'

export default Vue.extend({
  props: ['users'],
  components: {
    AvatarSmall,
    FullName,
    JobTitle
  },

  computed: {
    canShowMentionBox () {
      return size(this.users)
    }
  },

  methods: {
    choose (user) {
      this.$emit('choose', user)
    }
  }
})
</script>

<style lang="sass" scoped>
.comment-mentionbox
  bottom: 60px
  z-index: 1
  .people
    min-height: fit-content
    max-height: 135px
    width: 330px
    .user
      &:hover
        background: #f8f9fa
      .user-details
        .name
          font-size: 0.83rem
        .title
          font-size: 0.75rem
          margin-top: -2px
          color: #9da4b2
</style>
