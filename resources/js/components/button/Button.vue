<template lang="pug">
  button.btn.shadow-none.px-3(:class="buttonStyle")
    | {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['text', 'secondary'],
  computed: {
    buttonStyle () {
      return this.secondary ? 'btn-secondary' : 'btn-primary'
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/buttons'
</style>
