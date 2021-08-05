<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToPost()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-mention.mr-3 mentioned you on a post
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
    routeToPost () {
      const { notifiable: mention } = this.notification
      const route = { name: 'Post', params: { id: mention.post_id } }
      this.$router.push(route)
    }
  }
})
</script>
