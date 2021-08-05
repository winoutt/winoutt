<template lang="pug">
  .custom-menu.d-flex.justify-content-between
    .menu-item.custom-menu-item.w-50.cursor-pointer(:class="activeMenuItem === values[0] ? 'active-menu-item' : ''" @click="setActive(values[0])")
      h6 {{ titles[0] }}
    .menu-item.archived-menu-item.w-50.cursor-pointer(:class="activeMenuItem === values[0] ? '' : 'active-menu-item'" @click="setActive(values[1])")
      h6 {{ titles[1] }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['titles', 'values', 'value'],
  data () {
    return {
      activeMenuItem: this.value
    }
  },

  watch: {
    value: function (newValue) {
      this.activeMenuItem = newValue
    }
  },

  methods: {
    setActive (item) {
      this.activeMenuItem = item
      this.$emit('input', this.activeMenuItem)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables.scss'

.custom-menu
  .menu-item
    border-bottom: 3px solid #cdcdcd
    transition: border-bottom 0.4s
    h6
      font-size: 0.9375rem
      color: #cdcdcd
      transition: color 0.4s
  .archived-menu-item
    text-align: right
  .active-menu-item
    border-color: $primary
    h6
      color: $primary
</style>
