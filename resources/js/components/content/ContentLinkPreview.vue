<template lang="pug">
  a.content-link-preview.d-flex.rounded.border.mb-1.bg-white(:href="linkPreview.url" target="_blank")
    .preview-image
      img.rounded-left(:src="linkPreview.image")
    .details
      .title.text-truncate.font-weight-bold {{ linkPreview.title }}
      .description.text-truncate {{ linkPreview.description }}
      small.url.text-truncate {{ linkPreview.url }}
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['linkPreview']
})
</script>

<style lang="sass" scoped>
.content-link-preview
  .preview-image, img
    width: 59px
    height: 59px
    object-fit: cover
  .details
    display: grid
    padding: 6px 10px
    .title
      margin-bottom: -5px
    .description
      font-size: 0.813rem
      margin-bottom: -2px
  &:hover
    color: inherit
</style>
