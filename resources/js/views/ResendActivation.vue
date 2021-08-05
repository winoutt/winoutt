<template lang="pug">
  AuthPage
    p Your email is not verified. If you didn’t receive the verification email please resend.
    ButtonLarge.button(text="Resend" @click.native="resendVerification()")
    .sign-in-link.text-center
      | Go back to
      router-link.color-primary(:to="{ name: 'SignIn' }")  Sign in
</template>

<script lang="ts">
import Vue from 'vue'
import VerificationRequest from '../Request/VerificationRequest'

import AuthPage from '../components/AuthPage.vue'
import ButtonLarge from '../components/button/ButtonLarge.vue'

export default Vue.extend({
  props: ['email'],
  components: {
    AuthPage,
    ButtonLarge
  },
  methods: {
    resendVerification () {
      const payload = { email: this.email }
      VerificationRequest.resend(payload)
    }
  }
})
</script>

<style lang="sass" scoped>
.button
  margin-bottom: 15px
p
  font-size: 0.875rem
  margin-bottom: 20px
</style>
