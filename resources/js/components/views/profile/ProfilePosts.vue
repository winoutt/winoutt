<template lang="pug">
  .profile-posts
    Post(v-for="post in posts" :post="post" :key="post.id")
</template>

<script lang="ts">
import Vue from 'vue'
import PostState from '../../../State/PostState'

import Post from '../../post/Post.vue'

export default Vue.extend({
  components: {
    Post
  },

  computed: {
    posts () {
      return PostState.collectPosts()
    }
  }
})
</script>
