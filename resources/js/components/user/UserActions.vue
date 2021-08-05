<template lang="pug">
  .user-actions.d-flex
    ButtonSmall.ignore.mt-0(
      text="Pending"
      :secondary="true"
      v-if="isCancelable && !onlyMessageButton"
      @click.native.prevent="openCancelRequestModal()"
    )
    ButtonOutlineSmall.connect.align-self-center(
      text="Connect"
      v-if="!user.is_user && isRequestable && !onlyMessageButton"
      @click.native.prevent="openConnectionRequestModal()"
    )
    ButtonOutlineSmall.align-self-center(
      text="Message"
      @click.native.prevent="routeToMessages()"
      v-if="isDisconnectable"
    )
    ButtonDropdownSmall.ml-2(text="Connected" :secondary="true" v-if="disconnectButton && isDisconnectable")
      .dropdown-item.cursor-pointer(@click.prevent="openDisconnectModal()") Disconnect
      .dropdown-item.cursor-pointer(v-if="user.is_unfollowed" @click="follow()") Follow notifications
      .dropdown-item.cursor-pointer(v-else @click="unfollow()") Unfollow notifications
    ConnectionRequestButtons(@ignore="ignore()" @accept="accept()" v-if="(isAcceptable || isIgnorable) && swapRequestButtons")
    .connection-request.d-flex(v-else-if="!onlyMessageButton")
      ButtonSmall.mr-2(text="Accept" v-if="isAcceptable" @click.native.prevent="accept()")
      ButtonSmall.mt-0(text="Ignore" :secondary="true" v-if="isIgnorable" @click.native.prevent="ignore()")
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'
import ConnectionRequest from '../../Request/ConnectionRequest'
import UnfollowRequest from '../../Request/UnfollowRequest'

import ButtonSmall from '../button/ButtonSmall.vue'
import ConnectionRequestButtons from '../ConnectionRequestButtons.vue'
import ButtonOutlineSmall from '../button/ButtonOutlineSmall.vue'
import ButtonDropdownSmall from '../button/ButtonDropdownSmall.vue'
import UserState from '../../State/UserState'
import AuthToken from '../../services/AuthToken'
import IntendedRedirect from '../../services/IntendedRedirect'

export default Vue.extend({
  props: ['user', 'disconnectButton', 'swapRequestButtons', 'onlyMessageButton'],
  components: {
    ButtonSmall,
    ConnectionRequestButtons,
    ButtonOutlineSmall,
    ButtonDropdownSmall
  },

  computed: {
    isRequestable () {
      return this.can(false, false, false)
    },
    isCancelable () {
      return this.can(false, true, false)
    },
    isAcceptable () {
      return this.can(false, false, true)
    },
    isIgnorable () {
      return this.can(false, false, true)
    },
    isDisconnectable () {
      return this.can(true, false, false)
    }
  },

  methods: {
    can (isConnected, isRequested, isReceived) {
      return this.user.is_connected === isConnected &&
        this.user.is_requested === isRequested &&
        this.user.is_received === isReceived
    },
    routeToMessages () {
      UserModalService.mutualConnections().close()
      const query = { user: this.user.id }
      this.$router.push({ name: 'Messages', query })
    },
    openDisconnectModal () {
      UserModalService.disconnectConfirm().open()
    },
    openCancelRequestModal () {
      UserState.replaceModal(this.user)
      UserModalService.cancelRequestConfirm().open()
    },
    openConnectionRequestModal () {
      if (!AuthToken.has()) return IntendedRedirect.profile(this.user.username)
      UserState.replaceConnectionRequestModal(this.user)
      UserModalService.connectionRequest().open()
    },
    accept () {
      UserModalService.mutualConnections().close()
      ConnectionRequest.accept(this.user.id)
    },
    ignore () {
      UserModalService.mutualConnections().close()
      ConnectionRequest.ignore(this.user.id)
    },
    follow () {
      UnfollowRequest.delete(this.user.id)
    },
    unfollow () {
      UnfollowRequest.create(this.user)
    }
  }
})
</script>
