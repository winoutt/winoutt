<template lang="pug">
  .messages-header.border-bottom
    router-link.user.d-flex.no-hover(
      :to="{ name: 'Profile', params: { username: chat.username } }"
    )
      AvatarSmall.mr-2(:user="chat")
      .user-details.d-flex.flex-column.justify-content-center.text-truncate
        FullName.font-weight-bold {{ chat.full_name }}
        small
          JobTitle.title.text-secondary {{ chat.title }}
</template>

<script lang="ts">
import Vue from 'vue'
import AvatarSmall from '../../avatar/AvatarSmall.vue'
import FullName from '../../FullName.vue'
import JobTitle from '../../JobTitle.vue'

export default Vue.extend({
  props: ['chat'],
  components: {
    AvatarSmall,
    FullName,
    JobTitle
  }
})
</script>

<style lang="sass" scoped>
.messages-header
  padding-bottom: 10px
  padding-top: 35px
  .title
    font-size: 0.813rem
</style>
