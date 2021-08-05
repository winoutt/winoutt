<template lang="pug">
  HeadingSmall.heading {{ heading }}
</template>

<script lang="ts">
import Vue from 'vue'

import HeadingSmall from '../heading/HeadingSmall.vue'

export default Vue.extend({
  props: ['heading'],

  components: {
    HeadingSmall
  }
})
</script>

<style lang="sass" scoped>
.heading
  margin-bottom: 20px
  font-size: 1.125rem
</style>
