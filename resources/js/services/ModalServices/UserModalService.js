import Modal from './ModalService'

export default {
  mutualConnections: () => {
    return new Modal('user', 'mutual-connections')
  },
  connections: () => {
    return new Modal('user', 'connections')
  },
  disconnectConfirm: () => {
    return new Modal('user', 'disconnect-confirm')
  },
  connectionRequest: () => {
    return new Modal('user', 'connection-request')
  },
  cancelRequestConfirm: () => {
    return new Modal('user', 'cancel-request-confirm')
  },
  report: () => {
    return new Modal('user', 'report')
  }
}
