import { isEmpty } from 'lodash'
import FavouriteHttp from '../Http/FavouriteHttp'
import PostState from '../State/PostState'
import Alert from '../services/Alert'
import AuthToken from '../services/AuthToken'
import IntendedRedirect from '../services/IntendedRedirect'

const FavouriteRequest = {
  async create (data) {
    if (!AuthToken.has()) return IntendedRedirect.post(data.postId)
    const { isFavourited } = await FavouriteHttp.create(data)
    if (!isFavourited) return
    PostState.markFavourited(data.postId)
    Alert.action.success('Added to Favorites', 'Undo', function () {
      FavouriteRequest.delete(data.postId)
    })
  },

  async paginate (nextPage = false) {
    if (nextPage === null) return
    const posts = await FavouriteHttp.paginate(nextPage)
    if (isEmpty(posts)) return
    if (nextPage) PostState.pushPosts(posts.data)
    else PostState.replacePosts(posts.data)
    PostState.replaceNextPage(posts.next_page_url)
    return posts
  },

  async delete (postId) {
    const { isDeleted } = await FavouriteHttp.delete(postId)
    if (!isDeleted) return
    PostState.removeFavourited(postId)
    Alert.action.success('Removed from Favorites', 'Undo', function () {
      FavouriteRequest.create({ postId })
    })
  }
}

export default FavouriteRequest
