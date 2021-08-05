<template lang="pug">
  .avatar-medium.position-relative
    img.rounded-circle(:src="user.avatar" alt="Avatar" :style="avatarSize")
    AvatarOnline.online(:user="user")
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
img
  width: 59px
  height: 59px
  object-fit: cover
.online
  width: 12px
  height: 12px
  bottom: 3px
  right: 3px
</style>
