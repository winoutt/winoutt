<template lang="pug">
  SettingsContentWrapper(heading="Appearance")
    CustomSwitch(text="Night mode" v-model="darkMode" @click.native="updateDarkMode()")
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
    darkMode: {
      get () { return SettingsState.collectIsDarkMode() },
      set (isDarkMode) { SettingsState.replaceDarkMode(isDarkMode) }
    }
  },

  methods: {
    updateDarkMode () {
      this.darkMode = !this.darkMode
      SettingsRequest.update()
    }
  }
})
</script>
