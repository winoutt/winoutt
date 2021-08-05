import Cookie from './Cookie'
import Router from './Router'

export default {
  redirect (intend) {
    Cookie.intendedRedirect.set(intend)
    Router.router.push({ name: 'SignIn' })
  },

  post (id) {
    const intend = Router.resolveHref('Post', { id })
    this.redirect(intend)
  },

  profile (username) {
    const intend = Router.resolveHref('Profile', { username })
    this.redirect(intend)
  }
}
