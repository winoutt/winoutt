<template lang="pug">
.top-posts
  HeadingSmall.my-3 Top posts of the week
  .posts.mb-3.mb-sm-0(v-if="!Util.isEmpty(posts)")
    Post(v-for="post in posts" :post="post" :key="post.id")
  NoResults(v-else text="The results are not available yet.")
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import PostState from '../State/PostState'
import PostRequest from '../Request/PostRequest'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import Request from '../Request/Request'

import HeadingSmall from '../components/heading/HeadingSmall.vue'
import Post from '../components/post/Post.vue'
import NoResults from '../components/NoResults.vue'
import PostModals from '../components/post/PostModals.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    Post,
    NoResults,
    PostModals
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [
      PostRequest.top(),
      PeopleRequest.mayknow(),
      HashtagRequest.trending()
    ]
    const { isFailed } = await Request.bulk(requests)
    if (!isFailed) next()
  },

  computed: {
    posts () {
      return PostState.collectPosts()
    }
  }
})
</script>
