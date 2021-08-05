<template lang="pug">
  .form-group
    input.form-control.shadow-none(
      :type="type"
      :placeholder="placeholder"
      :value="value"
      @input="input"
      :readonly="readonly"
    )
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['type', 'placeholder', 'value', 'readonly'],
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
</style>
