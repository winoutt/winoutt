<template lang="pug">
.row
  .col-md-144.col-lg-143.offset-lg-1.col-xl-140.offset-xl-4
    HeadingSmall.my-3(v-if="heading") {{ heading }}
    slot
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['heading']
})
</script>
