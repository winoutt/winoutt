import AuthToken from './AuthToken'

export default {
  listen: {
    setOffline () {
      window.onbeforeunload = function () {
        const url = `${process.env.MIX_APP_URL}/api/users/status`
        const body = JSON.stringify({
          is_online: false,
          authorization: `Bearer ${AuthToken.token()}`
        })
        navigator.sendBeacon(url, body)
      }
    }
  }
}
