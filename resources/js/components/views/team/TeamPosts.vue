<template lang="pug">
.col-144
  .team-posts.position-relative#team-posts
    PostNew
    .posts(v-if="!Util.isEmpty(posts)")
      Post(v-for="post in posts" :post="post" :key="post.id")
    .no-posts.text-center(v-else)
      p.mb-1 No one has shared any posts yet.
      p Be the first to
        span.text-primary.cursor-pointer(@click="openCreateModal()")  create a new post.
</template>

<script lang="ts">
import Vue from 'vue'
import PostState from '../../../State/PostState'
import PostModalService from '../../../services/ModalServices/PostModalService'

import Post from '../../post/Post.vue'
import PostNew from '../../post/PostNew.vue'

export default Vue.extend({
  components: {
    Post,
    PostNew
  },

  computed: {
    posts () {
      return PostState.collectPosts()
    }
  },
  methods: {
    openCreateModal () {
      PostModalService.create().open()
    }
  }
})
</script>
