<template lang="pug">
button.btn.article-go-back-to-feed.shadow-none.border.px-3.text-nowrap.btn-custom-grey(
  data-dismiss='modal'
  aria-label='Close'
  @click.prevent.stop="discardConfirm()"
) Go back to feed
</template>

<script lang="ts">
import Vue from 'vue'
import ArticleModalService from '../../services/ModalServices/ArticleModalService'

export default Vue.extend({
  props: ['can-discard-confirm'],
  methods: {
    discardConfirm () {
      if (this.canDiscardConfirm) ArticleModalService.discardConfirm().open()
      else {
        ArticleModalService.write().close()
        ArticleModalService.read().close()
      }
    }
  }
})
</script>
