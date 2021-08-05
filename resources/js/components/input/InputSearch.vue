<template lang="pug">
  .input-group
    .input-group-prepend
      Icon.icon-search.input-group-text.bg-white(name="search" :class="updateBorder")
    input.form-control.shadow-none(type="text" :placeholder="placeholder" :value="value" @input="input" @focus="canUpdateBorder = true" @blur="canUpdateBorder = false")
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['placeholder', 'value'],
  components: {
    Icon
  },

  computed: {
    updateBorder () {
      return this.canUpdateBorder ? 'update-border' : ''
    }
  },

  data () {
    return {
      canUpdateBorder: false
    }
  },

  methods: {
    input (event) {
      this.$emit('input', event.target.value)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.input-group
  margin-bottom: 10px
  input
    height: 39px
    border-left: none
  .input-group-prepend
    border-right: none
    .icon-search
      width: 37px
      height: 39px
      padding-left: 19px
      padding-right: 0

.update-border
  border-color: rgba($primary, 0.5)
  transition: 0.4s
</style>
