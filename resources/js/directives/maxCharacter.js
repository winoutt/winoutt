import Vue from 'vue'
import { size } from 'lodash'
import $ from 'jquery'
import Validate from '../services/Validate'

export default Vue.directive('max-character', {
  bind (element, binding, vnode) {
    $(element).on('input paste', function () {
      setTimeout(() => {
        const value = element.getAttribute('data-value')
        const maxLength = binding.value
        const charLength = size(value)
        const isExceed = charLength > maxLength
        if (isExceed) {
          Validate.helperText().addTo(element)
          Validate.highlighBorder().addTo(element)
        } else {
          Validate.helperText().removeFrom(element)
          Validate.highlighBorder().removeFrom(element)
        }
      }, 100) // Firefox input listen like $nextTick()
    })
  }
})
