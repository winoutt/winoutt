import $ from 'jquery'

export default {
  selector: '.textarea-autosize',

  show () {
    const hasModal = $('.modal.show').length
    if (!hasModal) $('body.scroll').css('overflow', 'auto')
  },

  hide () {
    $('body').css('overflow', 'hidden')
  }
}
