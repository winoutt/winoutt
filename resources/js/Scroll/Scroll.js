import $ from 'jquery'
import { round } from 'lodash'

export default {
  destroy (wrapper) {
    $(wrapper).off('scroll')
  },

  toBottom (wrapper, content) {
    $(wrapper).animate({
      scrollTop: $(content).height()
    }, 300)
  },

  toTop (wrapper, duration = 300) {
    $(wrapper).animate({ scrollTop: 0 }, duration)
  },

  to (wrapper, height) {
    $(wrapper).animate({ scrollTop: height }, 0)
  },

  onBottom (wrapper, content, callback) {
    $(wrapper).on('scroll', () => {
      const position = $(wrapper).scrollTop() + $(wrapper).height()
      if (position !== round($(content).height())) return
      callback()
    })
  },

  onTop (wrapper, callback) {
    $(wrapper).scroll(function () {
      const position = $(wrapper).scrollTop()
      if (position !== 0) return
      callback()
    })
  }
}
