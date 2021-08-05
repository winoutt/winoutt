<template lang="pug">
.notification-wrapper.cursor-pointer(@click="routeToProfile()")
  FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
  .notification-accept.mr-3 accepted your connection request
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
    routeToProfile () {
      const { username } = this.notification.connection
      const params = { username }
      this.$router.push({ name: 'Profile', params  })
    }
  }
})
</script>
