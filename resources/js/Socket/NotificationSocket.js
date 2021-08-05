import { isEmpty } from 'lodash'
import Socket from './Socket'
import UserState from '../State/UserState'
import NotificationState from '../State/NotificationState'
import NotificationRequest from '../Request/NotificationRequest'
import Page from '../services/Page'

function channel () {
  const user = UserState.collectUser()
  return `user.${user.id}`
}

const tracker = {
  created: false
}

export default {
  listen: {
    created: () => {
      if (Socket.isListening(tracker, 'created')) return
      Socket.safeBoot()
      Socket.echo.private(channel())
        .listen('.notification.created', async data => {
          const { notification_id: notificationId } = data
          const notification = await NotificationRequest.read(notificationId)
          if (isEmpty(notification)) return
          const isConnectionRequest = notification.type === 'connection_request'
          if (isConnectionRequest) {
            NotificationState.addConnectionRequest(notification)
          } else NotificationState.addNotification(notification)
          NotificationState.incrementUnreadsCount()
        })
    }
  },

  leave () {
    if (Socket.echo) {
      tracker.created = false
      Socket.echo.leave(channel())
    }
  }
}
