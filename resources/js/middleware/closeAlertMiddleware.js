import Alert from '../services/Alert'

export default function (to, from, next) {
  Alert.clear()
  next()
}
