<template lang="pug">
  .settings-content-wrapper
    h5.font-weight-bold.my-3 {{ heading }}
    slot
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['heading']
})
</script>

<style lang="sass" scoped>
h5
  font-size: 1rem
</style>
