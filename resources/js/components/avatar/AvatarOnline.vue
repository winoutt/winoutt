<template lang="pug">
  .avatar-online.position-absolute.rounded-circle(v-if="canIndicateOnline")
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['user'],
  computed: {
    canIndicateOnline () {
      return !this.user.is_user && this.user.is_online
    }
  }
})
</script>

<style lang="sass" scoped>
.avatar-online
  background: #1ED761
  width: 11px
  height: 11px
  bottom: 0
  right: 0
  border: 2px solid #fff
</style>
