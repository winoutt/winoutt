import Modal from './ModalService'

export default {
  deleteAccount: () => {
    return new Modal('settings', 'delete-account')
  },
  cropAvatar: () => {
    return new Modal('settings', 'crop-avatar')
  },
  profileDiscardConfirm: () => {
    return new Modal('settings', 'profile-discard-confirm')
  }
}
