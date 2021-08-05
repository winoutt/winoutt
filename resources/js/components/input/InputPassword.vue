<template lang="pug">
  .input-group.input-password(:class="size")
    input.form-control.shadow-none(
      :type="type"
      :placeholder="placeholder"
      :value="value"
      @input="input"
      @focus="canUpdateBorder = true"
      @blur="canUpdateBorder = false"
    )
    .input-group-append
      Icon.icon-visibility.input-group-text.bg-white(:name="icon" @click.native="toggleCanShow()" :class="updateBorder")
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['placeholder', 'value', 'size'],
  components: {
    Icon
  },

  data () {
    return {
      canShow: false,
      canUpdateBorder: false
    }
  },

  computed: {
    type () {
      return this.canShow ? 'text' : 'password'
    },
    icon () {
      return this.canShow ? 'eye-off' : 'eye'
    },
    updateBorder () {
      return this.canUpdateBorder ? 'update-border' : ''
    }
  },

  methods: {
    input (event) {
      this.$emit('input', event.target.value)
    },
    toggleCanShow () {
      this.canShow = !this.canShow
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.input-group
  margin-bottom: 10px
  input
    height: 44px
    border-right: none
  .input-group-append
    border-left: none
  &.small
    input
      height: 33px
    .input-group-append
      .icon-visibility
        width: 46px
        height: 33px

.icon-visibility
  width: 46px
  height: 44px

.update-border
  border-color: rgba($primary, 0.5)
  transition: 0.4s
</style>
