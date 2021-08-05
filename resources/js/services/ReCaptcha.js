import script from 'scriptjs'
import $ from 'jquery'
import Alert from './Alert'

export default {
  siteKey: process.env.MIX_RECAPTCHA_SITE_KEY,

  initialize () {
    const cdn = `https://www.google.com/recaptcha/api.js?render=${this.siteKey}`
    script.get(cdn, () => null)
  },

  execute (action) {
    const { grecaptcha } = window
    return new Promise((resolve, reject) => {
      grecaptcha.ready(async () => {
        grecaptcha.execute(this.siteKey, { action })
          .then(token => resolve(token))
          .catch(() => {
            Alert.error('Unable to execute captcha, please refresh the page and try again')
            resolve(null)
          })
      })
    })
  },

  dispose () {
    $('.grecaptcha-badge').remove()
  }
}
