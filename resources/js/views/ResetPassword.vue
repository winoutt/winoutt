<template lang="pug">
  AuthPage
    p If you have forgotten your password, simply enter your email address and reset.
    InputLarge.email(placeholder="Email" v-model="user.email")
    ButtonLarge.button(text="Reset Password" @click.native="resetPassword()")
    .sign-in-link.text-center
      | Go back to
      router-link.color-primary(:to="{ name: 'SignIn' }")  Sign in
</template>

<script lang="ts">
import Vue from 'vue'
import PasswordRequest from '../Request/PasswordRequest'

import AuthPage from '../components/AuthPage.vue'
import InputLarge from '../components/input/InputLarge.vue'
import ButtonLarge from '../components/button/ButtonLarge.vue'

export default Vue.extend({
  components: {
    AuthPage,
    InputLarge,
    ButtonLarge
  },

  data () {
    return {
      user: {
        email: ''
      }
    }
  },

  methods: {
    resetPassword () {
      const payload = { email: this.user.email }
      PasswordRequest.reset(payload)
    }
  }
})
</script>

<style lang="sass" scoped>
.button
  margin-bottom: 15px
p
  font-size: 0.9375rem
  margin-bottom: 15px
.email
  margin-bottom: 25px
</style>
