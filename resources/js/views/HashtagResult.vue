<template lang="pug">
.hashtag-result
  HeadingSmall.my-3 Results for {{ `#${hashtag}` }}
  .posts(v-if="!Util.isEmpty(posts)")
    Post(v-for="post in posts" :post="post" :key="post.id")
  NoResults(v-else)
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import PostState from '../State/PostState'
import Request from '../Request/Request'
import PostScroll from '../Scroll/PostScroll'

import HeadingSmall from '../components/heading/HeadingSmall.vue'
import Post from '../components/post/Post.vue'
import NoResults from '../components/NoResults.vue'
import PostModals from '../components/post/PostModals.vue'

async function beforeEnter (to, from, next) {
  const requests = [
    HashtagRequest.posts(to.params.hashtag),
    PeopleRequest.mayknow(),
    HashtagRequest.trending()
  ]
  const { isFailed } = await Request.bulk(requests)
  if (!isFailed) next()
}

export default Vue.extend({
  components: {
    HeadingSmall,
    Post,
    NoResults,
    PostModals
  },

  beforeRouteEnter (to, from, next) {
    beforeEnter(to, from, next)
  },

  async beforeRouteUpdate (to, from, next) {
    PostScroll.hashtag.paginate.leave()
    await beforeEnter(to, from, next)
    const hashtag = to.params.hashtag
    PostScroll.hashtag.paginate.listen(hashtag)
  },

  computed: {
    hashtag () {
      return this.$route.params.hashtag
    },
    posts () {
      return PostState.collectPosts()
    }
  },

  beforeDestroy () {
    PostScroll.hashtag.paginate.leave()
  },

  mounted () {
    PostScroll.hashtag.paginate.listen(this.hashtag)
  }
})
</script>
