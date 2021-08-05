<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToPostComment()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-comment-mention.mr-3 mentioned you on a comment
</template>

<script lang="ts">
import Vue from 'vue'
import FullName from '../../FullName.vue'

export default Vue.extend({
  props: ['notification'],
  components: {
    FullName,
  },

  methods: {
    routeToPostComment () {
      const { notifiable: { comment } } = this.notification
      const route = { name: 'Post', params: { id: comment.post_id } }
      this.$router.push(route)
    }
  }
})
</script>
