<template lang="pug">
  SettingsContentWrapper(heading="Change password")
    .row
      .col-md-72
        .form-group
          label.font-weight-bold Current password
          ChromePasswordSuggestFix
          InputPassword(
            v-model="password.currentPassword"
            :data-value="password.currentPassword"
            required-field="true"
            size="small"
          )
    .row
      .col-md-72
        .form-group
          label.font-weight-bold New password
          InputPassword(
            v-model="password.newPassword"
            :data-value="password.newPassword"
            required-field="true"
            size="small"
          )
    .row
      .col
        SettingsButton(text="Save" @click.native="updatePassword()")
</template>

<script lang="ts">
import Vue from 'vue'
import PasswordRequest from '../../../Request/PasswordRequest'
import Validate from '../../../services/Validate'
import Alert from '../../../services/Alert'

import SettingsContentWrapper from './SettingsContentWrapper.vue'
import InputPassword from '../../input/InputPassword.vue'
import ChromePasswordSuggestFix from '../../ChromePasswordSuggestFix.vue'
import SettingsButton from '../settings/SettingsButton.vue'

export default Vue.extend({
  components: {
    SettingsContentWrapper,
    InputPassword,
    ChromePasswordSuggestFix,
    SettingsButton
  },

  data () {
    return {
      password: {
        currentPassword: '',
        newPassword: ''
      }
    }
  },

  methods: {
    async updatePassword () {
      if (!Validate.isFilledRequiredFields()) {
        return Alert.error(Validate.message.completeRequiredFields)
      }
      const { isUpdated } = await PasswordRequest.change(this.password)
      if (isUpdated) {
        this.password.currentPassword = ''
        this.password.newPassword = ''
      }
    }
  }
})
</script>
