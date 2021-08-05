import $ from 'jquery'
import { replace, stripTags } from 'voca'
import { every, forEach } from 'lodash'

const fields = ['input', 'textarea', 'select']

export default {
  message: {
    completeRequiredFields: 'Please complete all required fields.'
  },

  highlighBorder () {
    return {
      selector: '.form-helper-highlight',
      removeFrom (element) {
        forEach(fields, field => {
          const fieldElement = $(element).find(field)
          if (!fieldElement.length) return // continue
          fieldElement.css('border-color', '')
          $(element).find('.icon').css('border-color', '')
          return false // break
        })
        $(element).removeClass(replace(this.selector, '.', ''))
      },
      addTo (element) {
        $(element).addClass(replace(this.selector, '.', ''))
        forEach(fields, field => {
          const fieldElement = $(element).find(field)
          if (!fieldElement.length) return // continue
          const fieldStyle = fieldElement.attr('style') ? fieldElement.attr('style') : ''
          fieldElement.attr('style', `${fieldStyle} border-color: red !important;`)
          $(element).find('.icon')
            .attr('style', 'border-color: red !important')
          return false // break
        })
      },
      removeAll () {
        this.removeFrom(this.selector)
      }
    }
  },

  helperText () {
    return {
      selector: '.form-helper-text',
      element () {
        return $(document.createElement('small'))
          .addClass(replace(this.selector, '.', ''))
          .text('Maximum allowed characters exceeded')
          .css('position', 'absolute')
          .css('color', 'red')
      },
      existsOn (element) {
        return $(element).find(this.selector).length
      },
      removeFrom (element) {
        if (!this.existsOn(element)) return
        $(element).find(this.selector).remove()
      },
      addTo (element) {
        if (this.existsOn(element)) return
        $(element).append(this.element())
      },
      removeAll () {
        $(this.selector).remove()
      }
    }
  },

  isFilledRequiredFields () {
    const values = []
    const self = this
    $('[required-field]').each(function () {
      const requireField = $(this)
      const value = requireField.attr('data-value')
      if (value) {
        self.highlighBorder().removeFrom(this)
      } else {
        self.highlighBorder().addTo(this)
      }
      values.push(value)
      requireField.on('click input paste change', function () {
        self.highlighBorder().removeFrom(requireField)
      })
    })
    return every(values, value => value)
  },

  articleContentMaxCharacters (quillContent) {
    const isExceeded = this.isArticleContentMaxCharactersExceeded(quillContent)
    const element = '.ql-container'
    if (isExceeded) this.helperText().addTo(element)
    else this.helperText().removeFrom(element)
  },

  isArticleContentMaxCharactersExceeded (quillContent) {
    const content = stripTags(quillContent)
    return content.length > 55000
  }
}
