<template lang="pug">
  .user-starred.pb-2
    router-link.user.d-flex.justify-content-between.border.bg-white.no-hover(
      :to="{ name: 'Profile', params: { username: user.username } }"
      @click="hideModals()"
    )
      .profile.d-flex.align-items-center.text-truncate
        AvatarSmall.mr-2(:user="user")
        .details.d-flex.flex-column.text-truncate
          FullName.name.font-weight-bold {{ user.full_name }}
          JobTitle.title.text-secondary {{ user.title }}
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'
import PostModalService from '../../services/ModalServices/PostModalService'

import AvatarSmall from '../avatar/AvatarSmall.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'

export default Vue.extend({
  props: {
    user: { type: Object }
  },
  components: {
    AvatarSmall,
    FullName,
    JobTitle
  },

  methods: {
    hideModals () {
      UserModalService.mutualConnections().close()
      PostModalService.starred().close()
    }
  }
})
</script>

<style lang="sass" scoped>
.user
  border-radius: 8px
  padding: 10px 12px
  .name
    font-size: 1.02em
  .title
    font-size: 0.86rem
</style>
