<template lang="pug">
  .dropdown
    button#dropdownMenuButton.btn.shadow-none.dropdown-toggle(
      type='button'
      data-toggle='dropdown'
      aria-haspopup='true'
      aria-expanded='false'
      :class="buttonStyle"
    ) {{ text }}
    .dropdown-menu.shadow(aria-labelledby='dropdownMenuButton')
      slot
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
button
  padding: 6px 20px
  font-size: 0.875rem
.dropdown-toggle::after
  margin-bottom: -1px
</style>
