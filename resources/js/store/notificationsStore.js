import { forEach, filter, find, findIndex } from 'lodash'
import NotificationService from '../services/NotificationService'

export default {
  namespaced: true,
  state: {
    notifications: [],
    connectionRequests: [],
    nextPage: '',
    unreadsCount: 0
  },

  mutations: {
    addNotification (state, notification) {
      state.notifications.unshift(notification)
    },
    replaceNotifications (state, notifications) {
      state.notifications = notifications
    },
    replaceNextPage (state, nextPage) {
      state.nextPage = nextPage
    },
    pushNotifications (state, notifications) {
      forEach(notifications, notification => {
        state.notifications.push(notification)
      })
    },
    markFollowed (state, connectionId) {
      const notifications = filter(state.notifications, notification => {
        return notification.connection_id === connectionId
      })
      forEach(notifications, notification => {
        notification.is_unfollowed = false
      })
    },
    markUnfollowed (state, connectionId) {
      const notifications = filter(state.notifications, notification => {
        return notification.connection_id === connectionId
      })
      forEach(notifications, notification => {
        notification.is_unfollowed = true
      })
    },
    incrementUnreadsCount (state) {
      state.unreadsCount++
    },
    pullUnreadsCount (state) {
      state.unreadsCount = 0
    },
    markPostFollowed (state, postId) {
      const markables = filter(state.notifications, notification => {
        return NotificationService.getPostId(notification) === postId
      })
      forEach(markables, notification => {
        notification.is_post_unfollowed = false
      })
    },
    markPostUnfollowed (state, postId) {
      const markables = filter(state.notifications, notification => {
        return NotificationService.getPostId(notification) === postId
      })
      forEach(markables, notification => {
        notification.is_post_unfollowed = true
      })
    },
    replaceConnectionRequests (state, notifications) {
      state.connectionRequests = notifications
    },
    addConnectionRequest (state, notification) {
      state.connectionRequests.unshift(notification)
    },
    pullNotification (state, id) {
      const requestIndex = findIndex(state.connectionRequests, { id })
      state.connectionRequests.splice(requestIndex, 1)
      const notificationIndex = findIndex(state.notifications, { id })
      state.notifications.splice(notificationIndex, 1)
    },
    decrementUnreadsCount (state) {
      if (state.unreadsCount) state.unreadsCount--
    },
    markRead (state, id) {
      const notification = find(state.notifications, { id })
      const connectionRequest = find(state.connectionRequests, { id })
      if (notification) notification.is_read = true
      if (connectionRequest) connectionRequest.is_read = true
    },
    markAllRead (state) {
      const notifications = filter(state.notifications, { is_read: false })
      const requests = filter(state.connectionRequests, { is_read: false })
      const unreads = [...notifications, ...requests]
      forEach(unreads, notification => {
        notification.is_read = true
      })
    },
    replaceUnreadsCount (state, count) {
      state.unreadsCount = count
    }
  },

  getters: {
    notifications: state => state.notifications,
    connectionRequests: state => state.connectionRequests,
    nextPage: state => state.nextPage,
    unreadsCount: state => state.unreadsCount
  }
}
