import { isEmpty } from 'lodash'
import AuthState from '../State/AuthState'
import Cookie from './Cookie'
import LocalStorage from './LocalStorage'

export default {
  token () {
    return AuthState.collectToken() ||
      Cookie.authToken.get() ||
      LocalStorage.authToken.get()
  },

  has () {
    return !isEmpty(this.token())
  },

  remove () {
    AuthState.pullToken()
    Cookie.authToken.remove()
    LocalStorage.authToken.remove()
  }
}
