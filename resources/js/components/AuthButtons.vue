<template lang="pug">
  .auth-buttons
    ButtonOutline.button.mr-0.px-4.mt-2.mt-md-0.mr-2.mr-md-3(text="Sign in" @click.native="routeTo('SignIn')" :secondary="true")
    Button.button.px-4.mt-2.mt-md-0(text="Sign up" @click.native="routeTo('SignUp')")
</template>

<script lang="ts">
import Vue from 'vue'
import ButtonOutline from './button/ButtonOutline.vue'
import Button from './button/Button.vue'

export default Vue.extend({
  components: {
    ButtonOutline,
    Button
  },

  methods: {
    routeTo (routeName) {
      this.$router.push({ name: routeName })
    }
  }
})
</script>

<style lang="sass" scoped>
.button
  height: fit-content
  white-space: nowrap
  height: 37px

@media (max-width: 360px)
  .auth-buttons .button
    padding: 0 12px !important
    height: 34px
</style>
