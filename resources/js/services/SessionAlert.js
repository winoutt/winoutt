import SessionAlertState from '../State/SessionAlertState'
import SessionModalService from './ModalServices/SessionModalService'

export default {
  boot: function () {
    const existingInterval = SessionAlertState.collectInterval()
    if (existingInterval) return
    const interval = setInterval(() => {
      SessionModalService.alert().open()
      SessionAlertState.incrementTime()
    }, 20 * (60 * 1000)) // 20 mins
    SessionAlertState.replaceInterval(interval)
  },

  shutdown: function () {
    const interval = SessionAlertState.collectInterval()
    clearInterval(interval)
    SessionAlertState.pullInterval()
    SessionAlertState.pullTime()
  }
}
