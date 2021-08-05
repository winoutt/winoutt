<template lang="pug">
  .user-mutualConnections
    .d-flex.align-items-center.cursor-pointer(@click.prevent="openModal()" v-if="user.mutual_connections_count")
      Icon.icon-connections.mr-1(name="connections")
      .count.mr-1.text-secondary.text-truncate(
        :style="fontSize ? `font-size: ${fontSize}rem` : ''"
      ) {{ Humanize.count(user.mutual_connections_count) }} {{ mutualConnectionsText }}
</template>

<script lang="ts">
import Vue from 'vue'
import ConnectionRequest from '../../Request/ConnectionRequest'

import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['user', 'fontSize'],
  components: {
    Icon
  },

  computed: {
    mutualConnectionsText () {
      const text = 'mutual connection'
      return this.user.mutual_connections_count > 1 ? `${text}s` : text
    }
  },

  methods: {
    openModal () {
      ConnectionRequest.mutuals(this.user)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.user-mutualConnections
  min-height: 17px
  .count
    font-size: 0.75rem
  .icon-connections
    width: 14px
    height: 15px
    fill: $secondary
</style>
