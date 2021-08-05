<template lang="pug">
  ConfirmModal#user-disconnect-confirm-modal(title="Disconnect" @confirm="disconnect()" @cancel="cancel()")
    p.disconnect
      | Are you sure to disconnect
      FullName.name.font-weight-bold  {{ profile.full_name }}
      | ?
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'
import ConnectionRequest from '../../Request/ConnectionRequest'
import UserState from '../../State/UserState'

import ConfirmModal from '../modal/ConfirmModal.vue'
import FullName from '../FullName.vue'

export default Vue.extend({
  components: {
    ConfirmModal,
    FullName
  },

  computed: {
    profile () {
      return UserState.collectProfile()
    }
  },

  methods: {
    closeModal () {
      UserModalService.disconnectConfirm().close()
    },
    async disconnect () {
      await ConnectionRequest.disconnect(this.profile.id)
      this.closeModal()
    },
    cancel () {
      this.closeModal()
    }
  }
})
</script>

<style lang="sass" scoped>
#user-disconnect-confirm-modal
  z-index: 1050
.name
  display: contents
</style>
