import Echo from 'laravel-echo'
import Pusher from 'pusher-js' // eslint-disable-line
import { isEmpty } from 'lodash'
import AuthToken from '../services/AuthToken'

export default {
  echo: {},

  boot () {
    this.echo = new Echo({
      broadcaster: 'pusher',
      key: process.env.MIX_PUSHER_APP_KEY,
      cluster: process.env.MIX_PUSHER_APP_CLUSTER,
      encrypted: true,
      auth: {
        headers: {
          Authorization: `Bearer ${AuthToken.token()}`
        }
      }
    })
  },

  isListening(tracker, event) {
    const isListening = tracker[event]
    if (!isListening) tracker[event] = true
    return isListening
  },

  safeBoot () {
    if (isEmpty(this.echo)) this.boot()
  }
}
