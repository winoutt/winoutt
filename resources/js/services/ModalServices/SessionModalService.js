import Modal from './ModalService'

export default {
  alert: () => {
    return new Modal('session', 'alert')
  }
}
