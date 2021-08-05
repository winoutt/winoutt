<template lang="pug">
  router-link.profile.text-center.no-hover.d-block(
    :to="{ name: 'Profile', params: { username: user.username } }"
    @click="hideMenu()"
  )
    AvatarMedium.avatar(:user="user")
    HeadingSmall.name
      FullName.full-name {{ user.full_name }}
    JobTitle.title {{ user.title }}
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../State/UserState'
import MobileMenu from '../../services/MobileMenu'

import AvatarMedium from '../avatar/AvatarMedium.vue'
import HeadingSmall from '../heading/HeadingSmall.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'

export default Vue.extend({
  components: {
    AvatarMedium,
    HeadingSmall,
    FullName,
    JobTitle
  },

  computed: {
    user () {
      return UserState.collectUser()
    }
  },

  methods: {
    hideMenu () {
      MobileMenu.hide()
    }
  }
})
</script>

<style lang="sass" scoped>
.profile
  margin-bottom: 24px
  .avatar
    margin-bottom: 12px
    display: inline-block
  .name
    margin-bottom: 2px
    .full-name
      font-size: 1rem
  .title
    font-size: 0.875rem
    color: #9DA4B2
</style>
