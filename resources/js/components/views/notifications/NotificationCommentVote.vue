<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToPost()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-comment.mr-3 upvoted your comment
</template>

<script lang="ts">
import Vue from 'vue'
import FullName from '../../FullName.vue'

export default Vue.extend({
  props: ['notification'],
  components: {
    FullName,
  },

  data () {
    return {
      comment: this.notification.notifiable
    }
  },

  methods: {
    routeToPost () {
      const route = { name: 'Post', params: { id: this.comment.post_id } }
      this.$router.push(route)
    }
  }
})
</script>
