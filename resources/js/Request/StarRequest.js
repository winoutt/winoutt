import StarHttp from '../Http/StarHttp'
import PostState from '../State/PostState'
import AuthToken from '../services/AuthToken'
import IntendedRedirect from '../services/IntendedRedirect'

export default {
  async create (data) {
    if (!AuthToken.has()) return IntendedRedirect.post(data.postId)
    const { isStared } = await StarHttp.create(data)
    if (!isStared) return
    PostState.addStar(data.postId)
  },

  async delete (data) {
    const { isUnstared } = await StarHttp.delete(data)
    if (!isUnstared) return
    PostState.pullStar(data.postId)
  }
}
