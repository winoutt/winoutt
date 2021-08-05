<template lang="pug">
  .form-group
    select.form-control.shadow-none(:value="value" @change="input")
      slot
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['value'],
  methods: {
    input (event) {
      this.$emit('input', event.target.value)
    }
  }
})
</script>

<style lang="sass" scoped>
.form-group
  margin-bottom: 10px
  select
    height: 33px
</style>
