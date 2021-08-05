import AlertState from '../State/AlertState'

function success (message, timeout = null) {
  const alert = { type: 'success', message }
  if (timeout) AlertState.replaceTimeout(timeout)
  AlertState.replaceAlert(alert)
}

function error (message) {
  const alert = { type: 'error', message }
  AlertState.replaceAlert(alert)
}

export default {
  success,
  error,
  action: {
    success (message, buttonText, handler) {
      success(message)
      const action = { buttonText, handler }
      AlertState.replaceAction(action)
    },
    error (message, buttonText, handler) {
      error(message)
      const action = { buttonText, handler }
      AlertState.replaceAction(action)
    }
  },
  clear () {
    this.success('')
    this.error('')
    this.action.success('')
    this.action.error('')
  }
}
