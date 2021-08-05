import TeamState from '../State/TeamState'
import PostState from '../State/PostState'
import Scroll from './Scroll'
import TeamRequest from '../Request/TeamRequest'
import UserRequest from '../Request/UserRequest'
import FavouriteRequest from '../Request/FavouriteRequest'
import HashtagRequest from '../Request/HashtagRequest'
import UserState from '../State/UserState'

const config = {
  window: {
    wrapper: window,
    content: '#content'
  }
}

export default {
  team: {
    newPost () {
      Scroll.toTop('html')
      PostState.replaceHasNew(false)
    },
    paginate: {
      listen () {
        Scroll.onBottom(config.window.wrapper, config.window.content, () => {
          const team = TeamState.collectTeam()
          const nextPage = PostState.collectNextPage()
          TeamRequest.posts(team.id, nextPage)
        })
      },
      leave () {
        Scroll.destroy(config.window.wrapper)
      },
      relisten () {
        this.leave()
        this.listen()
      }
    }
  },
  user: {
    paginate: {
      listen () {
        Scroll.onBottom(config.window.wrapper, config.window.content, () => {
          const profile = UserState.collectProfile()
          const nextPage = PostState.collectNextPage()
          UserRequest.posts(profile.username, nextPage)
        })
      },
      leave () {
        Scroll.destroy(config.window.wrapper)
      },
      relisten () {
        this.leave()
        this.listen()
      }
    }
  },
  favourite: {
    paginate: {
      listen () {
        Scroll.onBottom(config.window.wrapper, config.window.content, () => {
          const nextPage = PostState.collectNextPage()
          FavouriteRequest.paginate(nextPage)
        })
      },
      leave () {
        Scroll.destroy(config.window.wrapper)
      }
    }
  },
  hashtag: {
    paginate: {
      listen (hashtag) {
        Scroll.onBottom(config.window.wrapper, config.window.content, () => {
          const nextPage = PostState.collectNextPage()
          HashtagRequest.posts(hashtag, nextPage)
        })
      },
      leave () {
        Scroll.destroy(config.window.wrapper)
      }
    }
  }
}
