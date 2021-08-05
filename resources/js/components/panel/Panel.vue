<template lang="pug">
  .container.border-right(v-if="isAppBooted")
    .row.h-100

      //- Sidebar
      .col-md-40.col-lg-30.col-xl-26.sidebar-wrapper.bg-white.d-none.d-md-block
        Sidebar

      //- Content area
      .col-md-103.offset-md-1.col-lg-112.offset-lg-1.col-xl-116.offset-xl-1.content#content
        Header
        .row.main-wrapper.position-relative
          .col-144
            slot
            Notes
    SidebarMobile
    UserMutualConnectionsModal
    UserConnectionsModal
    UserConnectionRequestModal
    UserCancelRequestConfirmModal
    SessionAlertModal
    Slider
</template>

<script lang="ts">
import Vue from 'vue'
import SessionAlert from '../../services/SessionAlert'
import AuthRequest from '../../Request/AuthRequest'
import MessageRequest from '../../Request/MessageRequest'
import ChatRequest from '../../Request/ChatRequest'
import Request from '../../Request/Request'
import MessageSocket from '../../Socket/MessageSocket'
import AppState from '../../State/AppState'
import NotificationSocket from '../../Socket/NotificationSocket'
import UserStatusRequest from '../../Request/UserStatusRequest'
import OnlineStatus from '../../services/OnlineStatus'
import ACMSocket from '../../Socket/ACMSocket'
import NotificationRequest from '../../Request/NotificationRequest'

import Sidebar from '../sidebar/Sidebar.vue'
import Header from '../Header.vue'
import Notes from '../notes/Notes.vue'
import SessionAlertModal from '../modal/SessionAlertModal.vue'
import UserMutualConnectionsModal from '../user/UserMutualConnectionsModal.vue'
import UserConnectionsModal from '../user/UserConnectionsModal.vue'
import UserConnectionRequestModal from '../user/UserConnectionRequestModal.vue'
import UserCancelRequestConfirmModal from '../user/UserCancelRequestConfirmModal.vue'
import SidebarMobile from '../sidebar/SidebarMobile.vue'
import Slider from '../Slider.vue'

export default Vue.extend({
  props: ['heading', 'hideAside'],
  components: {
    Sidebar,
    SidebarMobile,
    Header,
    Notes,
    SessionAlertModal,
    UserMutualConnectionsModal,
    UserConnectionsModal,
    UserConnectionRequestModal,
    UserCancelRequestConfirmModal,
    Slider
  },

  computed: {
    isAppBooted () {
      return AppState.collectIsBooted()
    }
  },

  methods: {
    async boot () {
      const requests = [
        AuthRequest.user(),
        MessageRequest.unreadsCount(),
        NotificationRequest.unreadsCount(),
        ChatRequest.markDelivered(),
        UserStatusRequest.update(true)
      ]
      const { isFailed } = await Request.bulk(requests)
      if (isFailed) return
      OnlineStatus.listen.setOffline()
      AppState.replaceIsBooted(true)
      MessageSocket.listen.created()
      NotificationSocket.listen.created()
      ACMSocket.listen.deleted()
      SessionAlert.boot()
    }
  },

  mounted () {
    this.boot()
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.container
  background: $grey-light
  .sidebar-wrapper
    min-height: 100vh !important
  .content
    min-height: 100vh !important
    .aside-wrapper
      position: relative

.main-wrapper
  min-height: calc(100vh - 87px)

@media (min-width: 768px)
  .container
    max-width: 100%
@media (max-width: 767px)
  .main-wrapper
    min-height: calc(100vh - 158px)
</style>
