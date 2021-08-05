<template lang="pug">
  button.btn.btn-primary.shadow-none.mb-3.mt-2
    | {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['text']
})
</script>

<style lang="sass" scoped>
.btn
  padding: 7px 30px
</style>
