import ModalService from '../services/ModalServices/ModalService'

export default function (to, from, next) {
  ModalService.closeAll()
  next()
}
