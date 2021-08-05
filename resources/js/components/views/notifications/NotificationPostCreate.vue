<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToPost()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-star.mr-3 shared a post on {{ team.name }} team
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
      post: this.notification.notifiable,
      team: this.notification.notifiable.team
    }
  },

  methods: {
    routeToPost () {
      const route = { name: 'Post', params: { id: this.post.id } }
      this.$router.push(route)
    }
  }
})
</script>
