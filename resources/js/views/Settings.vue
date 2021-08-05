<template lang="pug">
.row
  .col-lg-43.col-xl-32
    HeadingSmall.mt-3 Settings
    SettingsMenu
  .col-lg-80.col-xl-68
    SettingsProfile(v-if="active === 'profile'")
    SettingsChangePassword(v-else-if="active === 'changePassword'")
    SettingsNotifications(v-else-if="active === 'notifications'")
    SettingsAppearance(v-else-if="active === 'appearance'")
    SettingsDeleteAccount(v-else-if="active === 'deleteAccount'")
    SettingsProfileUnsavedDiscardConfirmModal(@discard="discardProfile()")
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsState from '../State/SettingsState'
import AuthRequest from '../Request/AuthRequest'
import SettingsModalService from '../services/ModalServices/SettingsModalService'

import HeadingSmall from '../components/heading/HeadingSmall.vue'
import SettingsMenu from '../components/views/settings/SettingsMenu.vue'
import SettingsProfile from '../components/views/settings/SettingsProfile.vue'
import SettingsChangePassword from '../components/views/settings/SettingsChangePassword.vue'
import SettingsNotifications from '../components/views/settings/SettingsNotifications.vue'
import SettingsAppearance from '../components/views/settings/SettingsAppearance.vue'
import SettingsDeleteAccount from '../components/views/settings/SettingsDeleteAccount.vue'
import SettingsProfileUnsavedDiscardConfirmModal from '../components/views/settings/SettingsProfileUnsavedDiscardConfirmModal.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    SettingsMenu,
    SettingsProfile,
    SettingsChangePassword,
    SettingsNotifications,
    SettingsAppearance,
    SettingsDeleteAccount,
    SettingsProfileUnsavedDiscardConfirmModal
  },

  async beforeRouteEnter (to, from, next) {
    await AuthRequest.user()
    next()
  },

  beforeRouteLeave (to, from, next) {
    const isToAccountDelete = to.name === 'AccountDelete'
    if (isToAccountDelete) return next()
    const isUserUnsaved = SettingsState.isUserUnsaved()
    if (isUserUnsaved) {
      this.next = next
      SettingsModalService.profileDiscardConfirm().open()
    } else next()
  },

  computed: {
    active () {
      return SettingsState.collectActive()
    }
  },

  data () {
    return {
      next: () => undefined
    }
  },

  methods: {
    discardProfile () {
      this.next()
    }
  }
})
</script>
