<template lang="pug">
  AuthPage
    InputPassword(
      placeholder="New password"
      v-model="user.password"
      :data-value="user.password"
      required-field="true"
    )
    InputPassword.confirm(
      placeholder="Confirm password"
      v-model="user.confirmPassword"
      :data-value="user.confirmPassword"
      required-field="true"
    )
    ButtonLarge(text="Update Password" @click.native="updatePassword()")
</template>

<script lang="ts">
import Vue from 'vue'
import PasswordRequest from '../Request/PasswordRequest'
import Validate from '../services/Validate'
import Alert from '../services/Alert'

import AuthPage from '../components/AuthPage.vue'
import InputPassword from '../components/input/InputPassword.vue'
import ButtonLarge from '../components/button/ButtonLarge.vue'

export default Vue.extend({
  components: {
    AuthPage,
    InputPassword,
    ButtonLarge
  },

  data () {
    return {
      user: {
        password: '',
        confirmPassword: ''
      }
    }
  },

  methods: {
    updatePassword () {
      if (!Validate.isFilledRequiredFields()) {
        return Alert.error(Validate.message.completeRequiredFields)
      }
      const payload = { ...this.user, token: this.$route.params.token }
      PasswordRequest.update(payload)
    }
  }
})
</script>

<style lang="sass" scoped>
.confirm
  margin-bottom: 25px
</style>
