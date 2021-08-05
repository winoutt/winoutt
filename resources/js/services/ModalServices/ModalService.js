import $ from 'jquery'
import Validate from '../Validate'
import BodyOverflow from '../BodyOverflow'

export default class ModalService {
  constructor (component, modal) {
    this.component = component
    this.modal = modal
  }

  dom () {
    const seletor = `#${this.component}-${this.modal}-modal`
    const dom = $(seletor)
    return dom
  }

  open () {
    this.dom().modal('show')
    this.dom().on('hide.bs.modal', () => {
      Validate.helperText().removeAll()
      Validate.highlighBorder().removeAll()
    })
    this.dom().on('hidden.bs.modal', () => {
      BodyOverflow.show()
    })
    $('.modal-backdrop').hide()
    BodyOverflow.hide()
  }

  onOpen (callback) {
    this.dom().on('shown.bs.modal', () => callback())
  }

  close () {
    this.dom().modal('hide')
  }

  onClose (callback) {
    this.dom().on('hidden.bs.modal', () => callback())
  }

  onClosing (callback) {
    this.dom().on('hide.bs.modal', event => callback(event))
  }

  static closeAll () {
    $(function () {
      $('.modal').modal('hide')
      $('.modal-backdrop').remove()
    })
  }
}
