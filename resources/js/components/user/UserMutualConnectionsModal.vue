<template lang="pug">
  Modal#user-mutual-connections-modal(title="Mutual Connections" :footer="false")
    template(v-slot:body)
      .mutual-connections
        User(v-for="user in mutuals" :key="user.id" :user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../State/UserState'
import UserModalService from '../../services/ModalServices/UserModalService'
import UserScroll from '../../Scroll/UserScroll'

import Modal from '../modal/Modal.vue'
import User from './User.vue'

export default Vue.extend({
  components: {
    Modal,
    User
  },

  computed: {
    mutuals () {
      const mutuals = UserState.collectMutuals()
      return mutuals.data
    },
    user () {
      return UserState.collectMutualsModal()
    }
  },

  methods: {
    onOpen () {
      UserModalService.mutualConnections().onOpen(() => {
        UserScroll.mutuals.paginate.listen()
      })
    },
    onClose () {
      UserModalService.mutualConnections().onClose(() => {
        UserScroll.mutuals.paginate.leave()
      })
    }
  },

  mounted () {
    this.onOpen()
    this.onClose()
  }
})
</script>
