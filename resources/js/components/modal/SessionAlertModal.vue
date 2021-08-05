<template lang="pug">
  Modal#session-alert-modal(title="Take action alert" :border="true")
    template(v-slot:body)
      .session-alert
        | Hey
        span.name.font-weight-bold  {{ user.first_name }}
        | , you’ve been
        span.duration.font-weight-bold  online for {{ time }}.
        |  Knowledge is empowerment to EXECUTE your ideas! How can you take action NOW?
    template(v-slot:footer)
      .actions.d-flex.justify-content-end
        Button.mr-2(text="Keep me signed in" :secondary="true" @click.native="stay()")
        Button(text="Sign out" @click.native="signOut()")
</template>

<script lang="ts">
import Vue from 'vue'
import SessionModalService from '../../services/ModalServices/SessionModalService'
import SessionAlertState from '../../State/SessionAlertState'
import UserState from '../../State/UserState'
import AuthRequest from '../../Request/AuthRequest'

import Modal from './Modal.vue'
import Button from '../button/Button.vue'

export default Vue.extend({
  components: {
    Modal,
    Button
  },

  computed: {
    user () {
      return UserState.collectUser()
    },
    time () {
      const interval = SessionAlertState.collectTime()
      const hours = Math.floor(interval / 60)
      const minutes = interval % 60
      const isHourPlural = hours > 1
      const time = interval >= 60
        ? `${hours} ${isHourPlural ? 'hours' : 'hour'} ${minutes ? minutes + ' minutes' : ''}`
        : `${minutes} minutes`
      return time
    }
  },

  methods: {
    closeModal () {
      SessionModalService.alert().close()
    },
    signOut () {
      this.closeModal()
      AuthRequest.logout()
    },
    stay () {
      this.closeModal()
    }
  }
})
</script>

<style lang="sass" scoped>
#session-alert-modal
  z-index: 1043
</style>
