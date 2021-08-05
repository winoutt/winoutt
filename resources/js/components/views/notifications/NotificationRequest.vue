<template lang="pug">
  .notification-request.d-flex.flex-column.flex-xl-row.justify-content-between.border.border-top-0(
    :class="unreadClass(notification)"
    @click="markRead()"
  )
    .user.d-flex.align-items-start
      .avatar
        img(:src="notification.connection.avatar")
      .details.d-flex.flex-column.text-truncate
        router-link.no-hover(:to="{ name: 'Profile', params: { username: notification.connection.username } }")
          FullName.font-weight-bold.mr-1 {{ notification.connection.full_name }}
        small
          JobTitle.title {{ notification.connection.title }}
        UserMutualConnections(:user="notification.connection")
    .message.ml-0.ml-xl-3.mt-3.mt-xl-0
      ReadMore.read-more(:text="notification.connection.pivot.message" :max-chars="80")
    .actions.d-flex.justify-content-end.mt-3.mt-xl-0.ml-0.ml-xl-3
      template(v-if="notification.connection.is_received")
        ConnectionRequestButtons(@ignore="ignore()" @accept="accept()")
</template>

<script lang="ts">
import Vue from 'vue'
import ConnectionRequest from '../../../Request/ConnectionRequest'

import ConnectionRequestButtons from '../../ConnectionRequestButtons.vue'
import UserMutualConnections from '../../user/UserMutualConnections.vue'
import ReadMore from '../../ReadMore.vue'
import FullName from '../../FullName.vue'
import JobTitle from '../../JobTitle.vue'
import NotificationState from '../../../State/NotificationState'
import NotificationRequest from '../../../Request/NotificationRequest'

export default Vue.extend({
  props: ['notification'],

  components: {
    ConnectionRequestButtons,
    UserMutualConnections,
    ReadMore,
    FullName,
    JobTitle
  },

  methods: {
    async accept () {
      const { connection: user } = this.notification
      const { isAccepted } = await ConnectionRequest.accept(user.id)
      if (!isAccepted) return
      user.is_connected = true
      user.is_received = false
      NotificationState.pullNotification(this.notification.id)
      this.markRead()
    },
    async ignore () {
      const { connection: user } = this.notification
      const { isIgnored } = await ConnectionRequest.ignore(user.id)
      if (!isIgnored) return
      user.is_received = false
      NotificationState.pullNotification(this.notification.id)
      this.markRead()
    },
    unreadClass (notification) {
      const isUnread = !notification.is_read
      return { 'px-3 unread': isUnread }
    },
    markRead () {
      if (this.notification.is_read) return
      NotificationRequest.markRead(this.notification)
    }
  }
})
</script>

<style lang="sass" scoped>
.notification-request
  padding: 10px 15px
  background: #fff
  .user
    min-width: 200px
    .avatar img
      width: 37px
      height: 37px
      object-fit: contain
      border-radius: 50%
      margin-right: 11px
    .title
        font-size: 0.813rem
        color: #9DA4B2
        margin-top: -2px
  .read-more
    font-size: 0.813rem
    word-break: break-all
</style>
