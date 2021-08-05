<template lang="pug">
  .modal.modal-fullscreen-xl.fade(tabindex='-1' role='dialog' aria-hidden='true')
    .modal-dialog.modal-dialog-centered(role='document')
      .modal-content.bg-grey-light.border-0
        .modal-header.d-block
          .modal-header-content.d-flex.align-items-center.w-100
            slot(name="header-content")
            .close-wrapper.ml-auto
              slot(v-if="customClose" name="custom-close")
              .pr-2(v-else)
                Close
        .modal-body.scroll
          .modal-body-content
            slot(name="body")
        .modal-footer.border-0(v-if="footer")
          .footer-wrapper.m-0.w-100
            slot(name="footer")
</template>

<script lang="ts">
import Vue from 'vue'
import Close from '../Close.vue'

export default Vue.extend({
  props: {
    footer: {
      type: Boolean,
      default: true
    },
    customClose: {
      type: Boolean
    }
  },
  components: {
    Close
  }
})
</script>

<style lang="sass" scoped>
.modal-header
  padding: 16px 26px
.modal.fade .modal-dialog
  transition: none
  transform: none
</style>
