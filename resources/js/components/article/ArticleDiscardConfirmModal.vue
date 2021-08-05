<template lang="pug">
  ConfirmModal#article-discard-confirm-modal(title="Discard article" @confirm="discard()" @cancel="cancel()")
    p.disconnect
      | Would you like to discard current article?
</template>

<script lang="ts">
import Vue from 'vue'
import ArticleModalService from '../../services/ModalServices/ArticleModalService'
import ConfirmModal from '../modal/ConfirmModal.vue'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  methods: {
    closeModal () {
      ArticleModalService.discardConfirm().close()
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
