import Scroll from './Scroll'
import ChatRequest from '../Request/ChatRequest'
import ChatState from '../State/ChatState'

const config = {
  wrapper: '#chats-wrapper',
  content: '#chats'
}

export default {
  paginate: {
    listen () {
      Scroll.onBottom(config.wrapper, config.content, () => {
        const nextPage = ChatState.collectNextPage()
        const tab = ChatState.collectTab()
        if (tab === 'active') ChatRequest.paginate(nextPage)
        else if (tab === 'archived') ChatRequest.archived(nextPage)
      })
    },
    leave () {
      Scroll.destroy(config.wrapper)
    }
  }
}
