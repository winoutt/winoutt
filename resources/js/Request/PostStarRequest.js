import { isEmpty } from 'lodash'
import PostStarHttp from '../Http/PostStarHttp'
import UserState from '../State/UserState'
import Alert from '../services/Alert'

export default {
  async paginate (postId, nextPage = false) {
    if (nextPage === null) return
    const response = await PostStarHttp.paginate(postId, nextPage)
    const { is_author_star_viewed: isAuthorStarViewed, stars } = response
    if (isEmpty(stars)) return
    if (!isAuthorStarViewed) {
      const message = 'Only you can see the total number of stars on your post.'
      Alert.success(message, 10)
    }
    if (nextPage) UserState.pushPostStars(stars)
    else UserState.replacePostStars(stars)
    return stars
  }
}
