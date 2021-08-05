<template lang="pug">
PanelContentTwoColumn(:heading="heading")
  .row
    .col-lg-134.offset-lg-5.col-xl-124.offset-xl-10
      slot
</template>

<script lang="ts">
import Vue from 'vue'

import PanelContentTwoColumn from './PanelContentTwoColumn.vue'

export default Vue.extend({
  props: ['heading'],

  components: {
    PanelContentTwoColumn
  }
})
</script>
