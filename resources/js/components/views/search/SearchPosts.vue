<template lang="pug">
  .search-posts
    template(v-if="posts.length")
      h6.font-weight-bold.mb-3 Posts
      Post(v-for="post in posts" :post="post" :key="post.id")
</template>

<script lang="ts">
import Vue from 'vue'
import Post from '../../post/Post.vue'

export default Vue.extend({
  props: ['posts'],
  components: {
    Post
  }
})
</script>

<style lang="sass" scoped>
h6
  font-size: 1.125rem
</style>
