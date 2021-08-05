<template lang="pug">
  .modal.fade(tabindex='-1' role='dialog' aria-hidden='true' data-backdrop="static")
    .modal-dialog.modal-dialog-centered(role='document' :class="modalType")
      .modal-content(:class="border ? 'border' : 'border-0'")
        .modal-header
          .modal-header-content.d-flex.align-items-center.w-100
            h5.modal-title {{ title }}
            .close-wrapper.ml-auto.pr-2
              Close
        .modal-body
          .scroll
            .modal-body-content
              slot(name="body")
        .modal-footer.border-top(v-if="footer")
          .footer-wrapper.m-0.w-100
            slot(name="footer")
</template>

<script lang="ts">
import Vue from 'vue'
import Close from '../Close.vue'

export default Vue.extend({
  props: {
    title: { type: String },
    type: { type: String },
    footer: {
      type: Boolean,
      default: true
    },
    border: { type: Boolean }
  },
  components: {
    Close
  },

  computed: {
    modalType () {
      return this.type === 'large' ? 'modal-lg' : ''
    }
  }
})
</script>

<style lang="sass" scoped>
.modal
  overflow-y: hidden !important
.modal-content
  border-radius: 3px
  .modal-header
    padding: 16px 20px
  .modal-body
    padding: 12px 20px
    .modal-body-content
      max-height: calc(100vh - 202px)
  .modal-footer
    border-radius: 8px
    padding: 12px 20px
    background: #fff
    border-radius: 3px
</style>
