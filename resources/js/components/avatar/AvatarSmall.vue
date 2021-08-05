<template lang="pug">
  .avatar-small.position-relative
    img.rounded-circle(:src="user.avatar" alt="Avatar" :style="avatarSize")
    AvatarOnline(:user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import AvatarOnline from './AvatarOnline.vue'

export default Vue.extend({
  props: ['user', 'size'],
  components: {
    AvatarOnline
  },

  computed: {
    avatarSize () {
      if (!this.size) return ''
      return `width: ${this.size}px; height: ${this.size}px`
    }
  }
})
</script>

<style lang="sass" scoped>
.avatar-small
  display: inline-table
  img
    width: 38px
    height: 38px
    object-fit: cover
</style>
