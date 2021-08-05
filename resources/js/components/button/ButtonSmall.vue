<template lang="pug">
  button.btn.shadow-none(:class="buttonStyle")
    Icon.mr-2(v-if="icon" :name="icon")
    | {{ text }}
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['text', 'icon', 'secondary', 'link'],
  components: {
    Icon
  },

  computed: {
    buttonStyle () {
      return this.secondary ? 'btn-secondary' : this.link ? 'link' : 'btn-primary'
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/buttons'

button
  padding: 6px 20px
  font-size: 0.875rem
  &.link
    font-weight: 700
    &:hover
      border: 1px solid $primary
</style>
