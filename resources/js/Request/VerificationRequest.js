import VerificationHttp from '../Http/VerificationHttp'
import Router from '../services/Router'
import Alert from '../services/Alert'

export default {
  async resend (data) {
    const { isResent } = await VerificationHttp.resend(data)
    if (!isResent) return
    Router.router.push({ name: 'SentActivation' })
  },

  async verify (data) {
    const { isVerified } = await VerificationHttp.verify(data)
    if (!isVerified) return
    Router.router.push({ name: 'SignIn' })
    Alert.success('Successfully verified your email')
  }
}
