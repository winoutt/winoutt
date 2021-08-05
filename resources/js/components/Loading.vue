<template lang="pug">
  .loading.d-flex
    Spinner
    .text {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'
import Spinner from './Spinner.vue'

export default Vue.extend({
  props: ['text'],
  components: {
    Spinner
  }
})
</script>

<style lang="sass" scoped>
.text
  margin-top: 1px
</style>
