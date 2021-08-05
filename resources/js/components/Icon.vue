<template lang="pug">
  <svg class="icon">
    <use :xlink:href="link"></use>
  </svg>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['name'],
  computed: {
    link () {
      return `/assets/icons.svg#${this.name}`
    }
  }
})
</script>
