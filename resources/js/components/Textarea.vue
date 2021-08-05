<template lang="pug">
  .form-group
    textarea.form-control.shadow-none(
      :placeholder="placeholder"
      :value="value"
      @input="input"
      @keydown.enter.exact="enter($event)"
      @keyup.esc="$emit('escape')"
      @blur="$emit('focusOut')"
      :rows="rows"
      :style="padding ? `padding: ${padding}` : ''"
      :class="autosizeClass"
    )
</template>

<script lang="ts">
import Vue from 'vue'
import Autosize from '../services/Autosize'

export default Vue.extend({
  props: [
    'placeholder',
    'value',
    'rows',
    'preventEnter',
    'padding',
    'autosize'
  ],

  computed: {
    autosizeClass () {
      return { 'textarea-autosize': this.autosize }
    }
  },

  methods: {
    input (event) {
      this.$emit('input', event.target.value)
    },
    enter (event) {
      if (this.preventEnter) event.preventDefault()
      this.$emit('enter')
    },
    initAutosize () {
      if (this.autosize) Autosize.boot()
    }
  },

  mounted () {
    this.initAutosize()
  }
})
</script>

<style lang="sass" scoped>
.form-group
  margin-bottom: 10px
  textarea
    height: 100%
    resize: none
</style>
