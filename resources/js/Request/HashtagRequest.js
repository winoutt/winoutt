import { isEmpty } from 'lodash'
import HashtagHttp from '../Http/HashtagHttp'
import HashtagState from '../State/HashtagState'
import PostState from '../State/PostState'
import Router from '../services/Router'

export default {
  async trending () {
    const hashtags = await HashtagHttp.trending()
    if (isEmpty(hashtags)) return
    HashtagState.replaceHashtags(hashtags)
    return hashtags
  },

  async posts (hashtag, nextPage = false) {
    if (nextPage === null) return
    const posts = await HashtagHttp.posts(hashtag, nextPage)
    if (isEmpty(posts)) return Router.router.push({ name: 'NotFound' })
    if (nextPage) PostState.pushPosts(posts.data)
    else PostState.replacePosts(posts.data)
    PostState.replaceNextPage(posts.next_page_url)
    return posts
  }
}
