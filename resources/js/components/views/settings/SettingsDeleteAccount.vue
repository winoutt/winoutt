<template lang="pug">
  .settings-delete-account
    SettingsContentWrapper(heading="Delete account")
      SettingsButton(text="Delete" @click.native="remove()")
    SettingsDeleteAccountModal
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsModalService from '../../../services/ModalServices/SettingsModalService'

import SettingsContentWrapper from './SettingsContentWrapper.vue'
import SettingsButton from '../settings/SettingsButton.vue'
import SettingsDeleteAccountModal from './SettingsDeleteAccountModal.vue'

export default Vue.extend({
  components: {
    SettingsContentWrapper,
    SettingsButton,
    SettingsDeleteAccountModal
  },

  methods: {
    remove () {
      SettingsModalService.deleteAccount().open()
    }
  }
})
</script>
