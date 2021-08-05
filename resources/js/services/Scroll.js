export default {
  toBottom: selector => {
    setTimeout(() => {
      var dom = document.querySelector(selector)
      if (dom) scroll()
      else setTimeout(scroll, 100)
      function scroll () {
        dom.scrollTop = dom.scrollHeight
      }
    }, 1)
  },

  toTop: selector => {
    setTimeout(() => {
      var dom = document.querySelector(selector)
      if (dom) scroll()
      else setTimeout(scroll, 100)
      function scroll () {
        dom.scrollTop = 0
      }
    }, 1)
  }
}
