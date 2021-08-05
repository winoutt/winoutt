<template lang="pug">
  SettingsContentWrapper(heading="Notifications")
    CustomSwitch(text="Enable notifications" v-model="isEnabled" @click.native="update()")
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsState from '../../../State/SettingsState'
import SettingsRequest from '../../../Request/SettingsRequest'

import SettingsContentWrapper from './SettingsContentWrapper.vue'
import CustomSwitch from '../../CustomSwitch.vue'

export default Vue.extend({
  components: {
    SettingsContentWrapper,
    CustomSwitch
  },

  computed: {
    isEnabled: {
      get () { return SettingsState.collectIsEnabledNotification() },
      set (isEnabled) { SettingsState.replaceEnableNotification(isEnabled) }
    }
  },

  methods: {
    async update () {
      this.isEnabled = !this.isEnabled
      await SettingsRequest.update()
    }
  }
})
</script>
