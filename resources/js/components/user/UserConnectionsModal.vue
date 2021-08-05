<template lang="pug">
  Modal#user-connections-modal(title="Connections" :footer="false")
    template(v-slot:body)
      .user-connections
        User(v-for="user in connections" :key="user.id" :user="user" :onlyMessageButton="true")
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
    connections () {
      const connections = UserState.collectConnections()
      return connections.data
    }
  },

  methods: {
    onOpen () {
      UserModalService.connections().onOpen(() => {
        UserScroll.connections.paginate.listen()
      })
    },
    onClose () {
      UserModalService.connections().onClose(() => {
        UserScroll.connections.paginate.leave()
      })
    }
  },

  mounted () {
    this.onOpen()
    this.onClose()
  }
})
</script>
