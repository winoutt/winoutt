<template lang="pug">
  .job-title.text-truncate(:style="style")
    slot
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: {
    lineClamp: {
      type: Number,
      default: 2
    },
    paddingBottom: {
      type: Number,
      default: 0
    }
  },

  computed: {
    style () {
      return `-webkit-line-clamp: ${this.lineClamp}; padding-bottom: ${this.paddingBottom}px;`
    }
  }
})
</script>

<style lang="sass" scoped>
.job-title
  display: -webkit-box
  -webkit-box-orient: vertical
  white-space: break-spaces
  max-width: 55ch
</style>
