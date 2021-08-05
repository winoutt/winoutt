import Modal from './ModalService'

export default {
  read: () => {
    return new Modal('article', 'read')
  },
  write: () => {
    return new Modal('article', 'write')
  },
  discardConfirm: () => {
    return new Modal('article', 'discard-confirm')
  }
}
