import Modal from './ModalService'

export default {
  deleteConfirm: () => {
    return new Modal('comment', 'delete-confirm')
  },
  report: () => {
    return new Modal('comment', 'report')
  }
}