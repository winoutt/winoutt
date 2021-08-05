import { isEmpty, cloneDeep } from 'lodash'
import AuthHttp from '../Http/AuthHttp'
import Cookie from '../services/Cookie'
import SessionAlert from '../services/SessionAlert'
import AuthState from '../State/AuthState'
import Socket from '../Socket/Socket'
import Router from '../services/Router'
import UserState from '../State/UserState'
import Alert from '../services/Alert'
import SettingsState from '../State/SettingsState'
import LocalStorage from '../services/LocalStorage'
import UserStatusRequest from '../Request/UserStatusRequest'
import MessageSocket from '../Socket/MessageSocket'
import NotificationSocket from '../Socket/NotificationSocket'
import ACMSocket from '../Socket/ACMSocket'

export default {
  async login (data) {
    const response = await AuthHttp.login(data)
    const { isLoggedIn, token, isNotVerified, email } = response
    if (isNotVerified) {
      return Router.router.push({ name: 'ResendActivation', query: { email } })
    }
    if (!isLoggedIn) return
    LocalStorage.authToken.set(token)
    Cookie.authToken.set(token)
    AuthState.replaceToken(token)
    Socket.boot()
    await this.user()
    const intend = Cookie.intendedRedirect.get()
    if (intend) {
      Cookie.intendedRedirect.remove()
      return Router.router.push(intend)
    }
    const isProfileCompleted = UserState.collectIsProfileCompleted()
    if (isProfileCompleted) {
      return Router.router.push({ name: 'Home' })
    } else {
      Router.router.push({ name: 'Settings' })
      Alert.success('Please complete your profile')
    }
  },

  async logout () {
    const { isLogout } = await AuthHttp.logout()
    const user = await UserStatusRequest.update(false)
    if (isEmpty(user) && !isLogout) return
    SessionAlert.shutdown()
    MessageSocket.leave()
    NotificationSocket.leave()
    ACMSocket.leave()
    Router.router.push({ name: 'SignIn' })
  },

  async register (data) {
    const { isRegistered } = await AuthHttp.register(data)
    if (!isRegistered) return
    Router.router.push({ name: 'SentActivation' })
  },

  async user () {
    const user = await AuthHttp.user()
    if (isEmpty(user)) return
    UserState.replaceUser(user)
    SettingsState.replaceUser(cloneDeep(user)) // Clone to avoid object reference
    SettingsState.replaceSettings(user.settings)
    return user
  }
}
