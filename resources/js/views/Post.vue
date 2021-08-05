<template lang="pug">
.post
  Post(:post="post" v-if="post.id")
  NoResults(v-else)
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import PostRequest from '../Request/PostRequest'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import Request from '../Request/Request'
import PostState from '../State/PostState'

import Post from '../components/post/Post.vue'
import NoResults from '../components/NoResults.vue'
import PostModals from '../components/post/PostModals.vue'

export default Vue.extend({
  components: {
    Post,
    NoResults,
    PostModals
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [
      PostRequest.read(to.params.id),
      PeopleRequest.mayknow(),
      HashtagRequest.trending()
    ]
    const { isFailed } = await Request.bulk(requests)
    if (!isFailed) next()
  },

  computed: {
    post () {
      return PostState.collectPost()
    }
  }
})
</script>

<style lang="sass" scoped>
.post
  margin-top: 20px
</style>
