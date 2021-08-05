<template lang="pug">
  AuthPage
    p We have sent you a verification email. Please verify your email to continue.
    ButtonLarge.button(text="Return to Sign In" @click.native="returnToSignIn()")
</template>

<script lang="ts">
import Vue from 'vue'
import AuthPage from '../components/AuthPage.vue'
import ButtonLarge from '../components/button/ButtonLarge.vue'

export default Vue.extend({
  components: {
    AuthPage,
    ButtonLarge
  },

  methods: {
    returnToSignIn () {
      this.$router.push({ name: 'SignIn' })
    }
  }
})
</script>

<style lang="sass" scoped>
p
  font-size: 0.875rem
  margin-bottom: 20px
</style>
