<template lang="pug">
.profile
  ProfileInfo
  ProfilePosts
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import UserRequest from '../Request/UserRequest'
import Request from '../Request/Request'
import PostScroll from '../Scroll/PostScroll'

import ProfileInfo from '../components/views/profile/ProfileInfo.vue'
import ProfilePosts from '../components/views/profile/ProfilePosts.vue'
import PostModals from '../components/post/PostModals.vue'

async function beforeEnter (to, from, next) {
  const requests = [
    UserRequest.read(to.params.username),
    UserRequest.posts(to.params.username),
    PeopleRequest.mayknow(),
    HashtagRequest.trending()
  ]
  const { isFailed } = await Request.bulk(requests)
  if (!isFailed) next()
}

export default Vue.extend({
  components: {
    ProfileInfo,
    ProfilePosts,
    PostModals
  },

  beforeRouteEnter (to, from, next) {
    beforeEnter(to, from, next)
  },

  beforeRouteUpdate (to, from, next) {
    PostScroll.user.paginate.relisten()
    beforeEnter(to, from, next)
  },

  beforeDestroy () {
    PostScroll.user.paginate.leave()
  },

  mounted () {
    PostScroll.user.paginate.listen()
  }
})
</script>

<style lang="sass" scoped>
.profile
  margin-top: 20px
</style>
