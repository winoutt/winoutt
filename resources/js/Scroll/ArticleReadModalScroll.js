import Scroll from './Scroll'

const config = {
  wrapper: '#article-read-modal .modal-body.scroll'
}

export default {
  toTop () {
    Scroll.toTop(config.wrapper, 0)
  }
}
