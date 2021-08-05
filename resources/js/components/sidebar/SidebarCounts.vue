<template lang="pug">
  .sidebar-counts.no-gutters
    .row
      .col
        .connections.d-flex.justify-content-between.border-top.border-bottom.py-2(
          @click="openConnectionsModal()"
          :class="{ 'cursor-pointer' : user.connections_count }"
        )
          p.mb-0 Connections
          p.font-weight-bold.mb-0(v-if="user.connections_count") {{ Humanize.count(user.connections_count) }}
    .row
      .col
        .posts.d-flex.justify-content-between.border-bottom.py-2
          p.mb-0 Posts
          p.font-weight-bold.mb-0(v-if="user.posts_count") {{ Humanize.count(user.posts_count) }}
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../State/UserState'
import ConnectionRequest from '../../Request/ConnectionRequest'

export default Vue.extend({
  computed: {
    user () {
      return UserState.collectUser()
    }
  },

  methods: {
    openConnectionsModal () {
      if (!this.user.connections_count) return
      ConnectionRequest.list(this.user)
    }
  }
})
</script>

<style lang="sass" scoped>
.sidebar-counts
  padding: 0 15px
  margin-bottom: 13px !important
  p
    font-size: 0.813rem
</style>
