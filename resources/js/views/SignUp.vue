<template lang="pug">
  AuthPage
    InputLarge(
      placeholder="Full name"
      v-model="user.full_name"
      :data-value="user.full_name"
      required-field="true"
    )
    InputLarge(
      placeholder="Email"
      v-model="user.email"
      :data-value="user.email"
      required-field="true"
    )
    InputPassword(
      placeholder="Password"
      v-model="user.password"
      @keyup.enter.native="signUp()"
      :data-value="user.password"
      required-field="true"
    )
    .agreement
      | By signing up, you agree to our
      router-link(:to="{ name: 'TermsOfUse' }" target="_blank")  Terms of Use
      |  and
      router-link(:to="{ name: 'PrivacyPolicy' }" target="_blank")  Privacy Policy
    ButtonLarge.button(text="Sign Up" @click.native="signUp()")
    .sign-in-link.text-center
      | Already have an account?
      router-link.color-primary(:to="{ name: 'SignIn' }")  Sign in
</template>

<script lang="ts">
import Vue from 'vue'
import AuthRequest from '../Request/AuthRequest'
import Validate from '../services/Validate'
import Alert from '../services/Alert'

import AuthPage from '../components/AuthPage.vue'
import InputLarge from '../components/input/InputLarge.vue'
import InputPassword from '../components/input/InputPassword.vue'
import ButtonLarge from '../components/button/ButtonLarge.vue'

export default Vue.extend({
  components: {
    AuthPage,
    InputLarge,
    InputPassword,
    ButtonLarge
  },

  data () {
    return {
      user: {
        full_name: '',
        email: '',
        password: ''
      }
    }
  },

  methods: {
    signUp () {
      if (!Validate.isFilledRequiredFields()) {
        return Alert.error(Validate.message.completeRequiredFields)
      }
      AuthRequest.register(this.user)
    }
  }
})
</script>

<style lang="sass" scoped>
.button
  margin-bottom: 15px
.agreement
  font-size: 0.75rem
  margin-bottom: 25px
</style>
