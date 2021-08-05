import Modal from './ModalService'

export default {
  create: () => {
    return new Modal('post', 'create')
  },
  share: () => {
    return new Modal('post', 'share')
  },
  starred: () => {
    return new Modal('post', 'starred')
  },
  report: () => {
    return new Modal('post', 'report')
  },
  deleteConfirm: () => {
    return new Modal('post', 'delete-confirm')
  },
  discardConfirm: () => {
    return new Modal('post', 'discard-confirm')
  }
}
