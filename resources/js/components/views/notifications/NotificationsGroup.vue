<template lang="pug">
  .notifications-group
    header.border
      h6.heading.font-weight-bold {{ title }}
    slot
</template>

<script lang="ts">
import Vue from 'vue'

import Notification from './Notification.vue'

export default Vue.extend({
  props: ['title'],

  components: {
    Notification
  }
})
</script>

<style lang="sass" scoped>
.notifications-group
  margin-bottom: 10px
  header
    background: #fff
    padding: 7px 15px
    border-top-left-radius: 3px
    border-top-right-radius: 3px
    .heading
      margin-bottom: 0
      font-size: 15px
</style>
