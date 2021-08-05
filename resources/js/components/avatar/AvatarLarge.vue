<template lang="pug">
  .avatar-large.position-relative
    img.rounded-circle(:src="user.avatar" alt="Avatar")
    AvatarOnline.online(:user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import AvatarOnline from './AvatarOnline.vue'

export default Vue.extend({
  props: ['user'],
  components: {
    AvatarOnline
  }
})
</script>

<style lang="sass" scoped>
img
  width: 90px
  height: 90px
  object-fit: cover
.online
  width: 15px
  height: 15px
  bottom: 7px
  right: 7px
</style>
