import Http from './Http'

export default {
  paginate (nextPage = null) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get('notifications/paginate')
  },

  read (notificationId) {
    return Http.get(`notifications/${notificationId}`)
  },

  markRead (id) {
    return Http.put(`notifications/${id}/read`)
  },

  markAllRead () {
    return Http.post('notifications/read/all')
  },

  unreadsCount () {
    return Http.get('notifications/unreads/count')
  },

  connectionRequest: {
    list () {
      return Http.get('notifications/connection-requests')
    }
  }
}
