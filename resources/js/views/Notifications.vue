<template lang="pug">
.notifications
  .header.d-flex.justify-content-between.align-items-center
    HeadingSmall.my-3 Notifications
    ButtonOutlineSmall.read-all-button.btn-custom-grey(
      v-if="!hasNoResult"
      text="Mark all as read"
      @click.native="read()"
    )
  .connection-requests
    NotificationsGroup(
      v-if="!Util.isEmpty(connectionRequests)"
      title="Connection requests"
    )
      NotificationReq(
        v-for="notification in connectionRequests"
        title="Connection requests"
        :notification="notification"
        :key="notification.id"
      )
  .notifications.mb-3(v-if="!Util.isEmpty(notificationGroups)")
    NotificationsGroup(
      v-for="(notificationGroup, title) in notificationGroups"
      :key="title"
      :title="title"
    )
      Notification(
        v-for="notification in notificationGroup"
        :notification="notification"
        :key="notification.id"
      )
  NoResults(v-if="hasNoResult" text="No new notifications!")
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty } from 'lodash'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import NotificationRequest from '../Request/NotificationRequest'
import NotificationState from '../State/NotificationState'
import Request from '../Request/Request'
import NotificationScroll from '../Scroll/NotificationScroll'

import NotificationsGroup from '../components/views/notifications/NotificationsGroup.vue'
import NoResults from '../components/NoResults.vue'
import NotificationReq from '../components/views/notifications/NotificationRequest.vue'
import Notification from '../components/views/notifications/Notification.vue'
import HeadingSmall from '../components/heading/HeadingSmall.vue'
import ButtonOutlineSmall from '../components/button/ButtonOutlineSmall.vue'

export default Vue.extend({
  components: {
    NotificationsGroup,
    NotificationReq,
    Notification,
    NoResults,
    HeadingSmall,
    ButtonOutlineSmall
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [
      NotificationRequest.connectionRequests.list(),
      NotificationRequest.paginate(),
      PeopleRequest.mayknow(),
      HashtagRequest.trending()
    ]
    const { isFailed } = await Request.bulk(requests)
    if (!isFailed) next()
  },

  computed: {
    notificationGroups () {
      const notifications = NotificationState.collectNotifications()
      return this.Util.groupByDate(notifications)
    },
    connectionRequests () {
      return NotificationState.collectConnectionRequests()
    },
    hasNoResult () {
      const hasNormal = !isEmpty(this.notificationGroups)
      const hasConnectionRequests = !isEmpty(this.connectionRequests)
      return !hasNormal && !hasConnectionRequests
    }
  },

  beforeDestroy () {
    NotificationScroll.paginate.leave()
  },

  methods: {
    read () {
      NotificationRequest.markAllRead()
    }
  },

  mounted () {
    NotificationScroll.paginate.listen()
  }
})
</script>

<style lang="sass" scoped>
.connection-requests
  margin-bottom: 20px
.header
  .read-all-button
    font-size: 0.813rem

@media only screen and (min-width: 768px) and (max-width: 992px)
  .header
    .read-all-button
      padding: 6px 13px
</style>
