<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToPost()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-star.mr-3 commented on a post you starred
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
      star: this.notification.notifiable
    }
  },

  methods: {
    routeToPost () {
      const route = { name: 'Post', params: { id: this.star.post_id } }
      this.$router.push(route)
    }
  }
})
</script>
