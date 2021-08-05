<template lang="pug">
.row.team
  .col-144.d-block.d-sm-none
    TeamInfo
  TeamCreatePost
  TeamPosts
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty } from 'lodash'
import TeamRequest from '../Request/TeamRequest'
import PostSocket from '../Socket/PostSocket'
import Request from '../Request/Request'
import PostScroll from '../Scroll/PostScroll'

import TeamCreatePost from '../components/views/team/TeamCreatePost.vue'
import TeamPosts from '../components/views/team/TeamPosts.vue'
import TeamInfo from '../components/views/team/TeamInfo.vue'
import TeamTopContributors from '../components/views/team/TeamTopContributors.vue'
import PostModals from '../components/post/PostModals.vue'

async function beforeEnter (to, from, next) {
  const team = await TeamRequest.read(to.params.slug)
  if (isEmpty(team)) return
  const requests = [
    TeamRequest.contributors(team.id),
    TeamRequest.posts(team.id)
  ]
  const { isFailed } = await Request.bulk(requests)
  if (isFailed) return
  PostSocket.listen.created()
  next()
}

export default Vue.extend({
  components: {
    TeamCreatePost,
    TeamPosts,
    TeamInfo,
    TeamTopContributors,
    PostModals
  },

  beforeRouteEnter (to, from, next) {
    beforeEnter(to, from, next)
  },

  beforeRouteUpdate (to, from, next) {
    PostScroll.team.paginate.relisten()
    beforeEnter(to, from, next)
  },

  beforeRouteLeave (to, from, next) {
    PostSocket.leave()
    next()
  },

  beforeDestroy () {
    PostScroll.team.paginate.leave()
  },

  mounted () {
    PostScroll.team.paginate.listen()
  }
})
</script>

<style lang="sass" scoped>
.team
  margin-top: 20px
</style>
