import { isEmpty } from 'lodash'
import PostHttp from '../Http/PostHttp'
import PostState from '../State/PostState'
import UserState from '../State/UserState'
import Router from '../services/Router'

export default {
  async create (data) {
    const post = await PostHttp.create(data)
    if (isEmpty(post)) return
    PostState.addPost(post)
    UserState.incrementPostsCount(post.user_id)
    return post
  },

  async delete (post) {
    const response = await PostHttp.delete(post.id)
    const { isDeleted } = response
    if (!isDeleted) return
    PostState.pullPost(post.id)
    UserState.decrementPostsCount(post.user_id)
    return response
  },

  async read (id, canUpdatePost = true) {
    const post = await PostHttp.read(id)
    if (isEmpty(post)) return Router.router.push({ name: 'NotFound' })
    if (canUpdatePost) PostState.replacePost(post)
    return post
  },

  async top () {
    const posts = await PostHttp.top()
    if (isEmpty(posts)) return
    PostState.replacePosts(posts)
    return posts
  }
}
