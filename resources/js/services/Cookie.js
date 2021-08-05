import Cookies from 'js-cookie'

const actions = {
  set (value) {
    return Cookies.set(this.key, value, {
      expires: 365 * 200 // never expire
    })
  },
  get () {
    return Cookies.get(this.key)
  },
  remove () {
    return Cookies.remove(this.key)
  }
}

const authToken = {
  key: 'auth_token',
  ...actions
}

const intendedRedirect = {
  key: 'intended_redirect',
  ...actions
}

export default { authToken, intendedRedirect }
