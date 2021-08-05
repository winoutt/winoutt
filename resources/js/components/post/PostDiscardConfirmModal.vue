<template lang="pug">
  ConfirmModal#post-discard-confirm-modal(title="Discard post" @confirm="discard()" @cancel="cancel()")
    p.disconnect
      | Would you like to discard current post?
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import ConfirmModal from '../modal/ConfirmModal.vue'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  methods: {
    closeModal () {
      PostModalService.discardConfirm().close()
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
