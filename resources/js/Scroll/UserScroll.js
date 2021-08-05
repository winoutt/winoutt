import Scroll from './Scroll'
import PostStarRequest from '../Request/PostStarRequest'
import ConnectionRequest from '../Request/ConnectionRequest'
import UserState from '../State/UserState'

const config = {
  starred: {
    wrapper: '#post-starred-modal .modal-body .scroll',
    content: '.starred'
  },
  mutuals: {
    wrapper: '#user-mutual-connections-modal .modal-body .scroll',
    content: '.mutual-connections'
  },
  connections: {
    wrapper: '#user-connections-modal .modal-body .scroll',
    content: '.user-connections'
  }
}

export default {
  starred: {
    paginate: {
      listen (postId) {
        Scroll.onBottom(config.starred.wrapper, config.starred.content, () => {
          const nextPage = UserState.collectPostStarsNextPage()
          PostStarRequest.paginate(postId, nextPage)
        })
      },
      leave () {
        Scroll.destroy(config.starred.wrapper)
      }
    }
  },
  mutuals: {
    paginate: {
      listen () {
        Scroll.onBottom(config.mutuals.wrapper, config.mutuals.content, () => {
          const mutuals = UserState.collectMutuals()
          const user = UserState.collectMutualsModal()
          ConnectionRequest.mutuals(user, mutuals.next_page_url)
        })
      },
      leave () {
        Scroll.destroy(config.mutuals.wrapper)
      }
    }
  },
  connections: {
    paginate: {
      listen () {
        Scroll.onBottom(config.connections.wrapper, config.connections.content, () => {
          const connections = UserState.collectConnections()
          const user = UserState.collectConnectionsModal()
          ConnectionRequest.list(user, connections.next_page_url)
        })
      },
      leave () {
        Scroll.destroy(config.connections.wrapper)
      }
    }
  }
}
