import { isEmpty } from 'lodash'
import PollVoteHttp from '../Http/PollVoteHttp'
import PostState from '../State/PostState'

export default {
  async create (data) {
    const post = await PollVoteHttp.create(data)
    if (isEmpty(post)) return
    PostState.amendPost(post)
  }
}
