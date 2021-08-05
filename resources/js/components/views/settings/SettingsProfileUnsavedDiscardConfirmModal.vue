<template lang="pug">
  ConfirmModal#settings-profile-discard-confirm-modal(title="Discard changes" @confirm="discard()" @cancel="cancel()")
    p.disconnect
      | Would you like to discard unsaved changes in profile settings?
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsModalService from '../../../services/ModalServices/SettingsModalService'
import ConfirmModal from '../../modal/ConfirmModal.vue'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  methods: {
    closeModal () {
      SettingsModalService.profileDiscardConfirm().close()
    },
    discard () {
      this.$emit('discard')
      this.closeModal()
    },
    cancel () {
      this.closeModal()
    }
  }
})
</script>
