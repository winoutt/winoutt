<template lang="pug">
  AuthPage
  InputLarge(
  placeholder="Email or Username"
  v-model="user.emailOrUsername"
  :data-value="user.emailOrUsername"
  required-field="true"
  )
  InputPassword(
  placeholder="Password"
  v-model="user.password"
  @keyup.enter.native="signIn()"
  :data-value="user.password"
  required-field="true"
  )
  ButtonLarge.button.mt-3(text="Sign In" @click.native="signIn()")
  .text-center
  router-link(:to="{ name: 'ResetPassword' }") Forgot password?
  .sign-in-link.mt-2
  | New to Oceanpace?
  router-link.color-primary(:to="{ name: 'SignUp' }") Sign up
</template>

<script lang="ts">
  import Vue from 'vue'
  import { clone } from 'lodash'
  import IsEmail from 'isemail'
  import AuthRequest from '../Request/AuthRequest'
  import AuthToken from '../services/AuthToken'
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

    data() {
      return {
        user: {
          emailOrUsername: '',
          password: ''
        }
      }
    },

    beforeRouteEnter(to, from, next) {
      /**
       * Remove authentication token only after redirect to SignIn
       * to avoid issues when using beforeRouteLeave in authenticated
       * pages. Currenlty public views' panels are rendering according
       * to the authentication token status. So when remove token
       * it will switch the panel and stuck the view on beforeRouteLeave
       * until invoke the next.
       */
      AuthToken.remove()
      next()
    },

    methods: {
      signIn() {
        if (!Validate.isFilledRequiredFields()) {
          return Alert.error(Validate.message.completeRequiredFields)
        }
        const payload = clone(this.user)
        const isEmail = IsEmail.validate(this.user.emailOrUsername)
        if (isEmail) payload.email = this.user.emailOrUsername
        else payload.username = this.user.emailOrUsername
        AuthRequest.login(payload)
      }
    }
  })
</script>

<style lang="sass" scoped>
  .button margin-bottom: 15px .form-check-label margin-bottom: 20px

</style>
