import PasswordHttp from '../Http/PasswordHttp'
import Router from '../services/Router'
import Alert from '../services/Alert'

export default {
  async reset (data) {
    const { isSent } = await PasswordHttp.reset(data)
    if (!isSent) return
    Router.router.push({ name: 'SentPasswordReset' })
  },

  async update (data) {
    const { isUpdated } = await PasswordHttp.update(data)
    if (!isUpdated) return
    Router.router.push({ name: 'SignIn' })
    Alert.success('Successfully updated password')
  },

  async change (data) {
    const response = await PasswordHttp.change(data)
    const { isUpdated } = response
    if (isUpdated) Alert.success('Successfully updated password')
    return response
  }
}
