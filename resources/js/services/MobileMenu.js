import $ from 'jquery'

export default {
  get dom () {
    return $('#mobile-menu')
  },

  show () {
    this.dom.removeClass('animate__slideOutLeft')
      .addClass('animate__slideInLeft')
      .show()
  },

  hide () {
    this.dom.removeClass('animate__slideInLeft')
      .addClass('animate__slideOutLeft')
      .hide(600)
  },

  toggle () {
    const isVisible = this.dom.is(':visible')
    isVisible ? this.hide() : this.show()
  }
}
