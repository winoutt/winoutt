import ContactHttp from '../Http/ContactHttp'
import Alert from '../services/Alert'
import ReCaptcha from '../services/ReCaptcha'
import Router from '../services/Router'

export default {
  async contact (data) {
    const recaptcha = await ReCaptcha.execute('helpContactSend')
    if (recaptcha) data.recaptcha = recaptcha
    else return
    const { isSent } = await ContactHttp.contact(data)
    if (isSent) {
      Router.router.push({ name: 'Home' })
      Alert.success('Successfully sent your feedback')
    }
    return isSent
  }
}
