import AuthToken from '../services/AuthToken'
import Alert from '../services/Alert'

export default function (to, from, next) {
  const hasAuthToken = AuthToken.has()
  if (!hasAuthToken) {
    Alert.error('Please sign in')
    return next({ name: 'SignIn' })
  }
  next()
}
