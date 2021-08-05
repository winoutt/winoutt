<template lang="pug">
router-link.user.d-flex.justify-content-between.align-items-center.bg-white.no-hover(
  :to="{ name: 'Profile', params: { username: user.username } }"
  @click="hideModal()"
)
  .profile.d-flex.text-truncate
    AvatarSmall.avatar(:user="user" :size="avatarSize")
    .details.d-flex.flex-column.text-truncate
      FullName.name.font-weight-bold {{ user.full_name }}
      JobTitle.title.text-secondary(:paddingBottom="titlePaddingBottom") {{ user.title }}
      slot(name="UserMutualConnections")
  UserActions.ml-2(
    v-if="userActions"
    :disconnectButton="disconnectButton"
    :onlyMessageButton="onlyMessageButton"
    :user="user"
    :swapRequestButtons="swapRequestButtons"
  ).align-self-center
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'

import AvatarSmall from '../avatar/AvatarSmall.vue'
import UserActions from './UserActions.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'

export default Vue.extend({
  props: {
    user: { type: Object },
    disconnectButton: { type: Boolean },
    userActions: { default: true },
    swapRequestButtons: { type: Boolean },
    avatarSize: { type: Number },
    onlyMessageButton: { type: Boolean },
    titlePaddingBottom: { type: Number, default: 0 }
  },
  components: {
    AvatarSmall,
    UserActions,
    FullName,
    JobTitle
  },

  methods: {
    hideModal () {
      UserModalService.mutualConnections().close()
    }
  }
})
</script>

<style lang="sass" scoped>
.user
  border-radius: 8px
  padding: 10px 0
  min-height: 74px
  .avatar
    margin-right: 0.6rem
  .name
    font-size: 0.875rem
  .title
    font-size: 0.813rem
</style>
