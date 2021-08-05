import { forEach } from 'lodash'
import $ from 'jquery'
import autosize from 'autosize'

export default {
  selector: '.textarea-autosize',

  reset () {
    const elements = document.querySelectorAll(this.selector)
    forEach(elements, element => {
      const event = new Event('input', { bubbles: true, cancelable: true })
      element.dispatchEvent(event)
    })
  },

  boot () {
    $(() => autosize($(this.selector)))
  }
}
