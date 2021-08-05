import Scroll from './Scroll'
import NotificationState from '../State/NotificationState'
import NotificationRequest from '../Request/NotificationRequest'

const config = {
  wrapper: window,
  content: '#content'
}

export default {
  paginate: {
    listen () {
      Scroll.onBottom(config.wrapper, config.content, () => {
        const nextPage = NotificationState.collectNextPage()
        NotificationRequest.paginate(nextPage)
      })
    },
    leave () {
      Scroll.destroy(config.wrapper)
    }
  }
}
