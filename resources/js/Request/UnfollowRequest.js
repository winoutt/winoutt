import UnfollowHttp from '../Http/UnfollowHttp'
import NotificationState from '../State/NotificationState'
import Alert from '../services/Alert'
import UserState from '../State/UserState'
import Page from '../services/Page'

const UnfollowRequest = {
  async create (user) {
    const data = { connectionId: user.id }
    const { isUnfollowed } = await UnfollowHttp.create(data)
    if (!isUnfollowed) return
    NotificationState.markUnfollowed(data.connectionId)
    UserState.markUnfollowed(data.connectionId)
    var alertMessage = `
      You will no longer receive notifications from ${user.full_name}.
    `
    if (Page.is('notifications') && user.is_connected) {
      alertMessage = `${alertMessage} You can re-follow them from their profile.`
    }
    Alert.action.success(alertMessage, 'Undo', function () {
      UnfollowRequest.delete(user.id)
    })
  },

  async delete (connectionId) {
    const { isFollowed } = await UnfollowHttp.delete(connectionId)
    if (!isFollowed) return
    NotificationState.markFollowed(connectionId)
    UserState.markFollowed(connectionId)
    Alert.success('Successfully followed')
  }
}

export default UnfollowRequest
