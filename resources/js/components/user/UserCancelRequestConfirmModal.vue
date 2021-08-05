<template lang="pug">
  ConfirmModal#user-cancel-request-confirm-modal(title="Cancel request" @confirm="cancelRequest()" @cancel="cancel()")
    p.disconnect
      | Are you sure to cancel the connection request?
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'
import ConfirmModal from '../modal/ConfirmModal.vue'
import UserState from '../../State/UserState'
import ConnectionRequest from '../../Request/ConnectionRequest'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  computed: {
    user () {
      return UserState.collectModal()
    }
  },

  methods: {
    closeModal () {
      UserModalService.cancelRequestConfirm().close()
    },
    async cancelRequest () {
      await ConnectionRequest.cancel(this.user.id)
      this.closeModal()
    },
    cancel () {
      this.closeModal()
    }
  }
})
</script>

<style lang="sass" scoped>
#user-cancel-request-confirm-modal
  z-index: 1050
</style>
