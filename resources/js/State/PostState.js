import State from './State'

export default {
  addPost (post) {
    State.store.commit('posts/addPost', post)
  },

  addComment (comment) {
    State.store.commit('posts/addComment', comment)
  },

  collectPosts () {
    return State.store.getters['posts/posts']
  },

  collectPost () {
    return State.store.getters['posts/post']
  },

  collectStarredModal () {
    return State.store.getters['posts/starredModal']
  },

  collectHasNew () {
    return State.store.getters['posts/hasNew']
  },

  collectNextPage () {
    return State.store.getters['posts/nextPage']
  },

  collectArticleEditorCover () {
    return State.store.getters['posts/articleEditorCover']
  },

  collectArticleEditorTitle () {
    return State.store.getters['posts/articleEditorTitle']
  },

  collectArticleEditorContent () {
    return State.store.getters['posts/articleEditorContent']
  },

  collectArticleEditorQuillEditor () {
    return State.store.getters['posts/articleEditorQuillEditor']
  },

  replacePosts (posts) {
    State.store.commit('posts/replacePosts', posts)
  },

  replacePost (post) {
    State.store.commit('posts/replacePost', post)
  },

  replaceStarredModal (post) {
    State.store.commit('posts/replaceStarredModal', post)
  },

  replaceNextPage (nextPage) {
    State.store.commit('posts/replaceNextPage', nextPage)
  },

  replaceHasNew (hasNew) {
    State.store.commit('posts/replaceHasNew', hasNew)
  },

  replaceArticleEditorCover (cover) {
    State.store.commit('posts/replaceArticleEditorCover', cover)
  },

  replaceArticleEditorTitle (title) {
    State.store.commit('posts/replaceArticleEditorTitle', title)
  },

  replaceArticleEditorContent (content) {
    State.store.commit('posts/replaceArticleEditorContent', content)
  },

  replaceArticleEditorQuillEditor (editor) {
    State.store.commit('posts/replaceArticleEditorQuillEditor', editor)
  },

  pushPosts (posts) {
    State.store.commit('posts/pushPosts', posts)
  },

  pushComments (id, comments) {
    const payload = { id, comments }
    State.store.commit('posts/pushComments', payload)
  },

  amendPost (post) {
    State.store.commit('posts/amendPost', post)
  },

  pullPost (post) {
    State.store.commit('posts/pullPost', post)
  },

  pullComment (id) {
    State.store.commit('posts/pullComment', id)
  },

  markFavourited (id) {
    State.store.commit('posts/markFavourited', id)
  },

  addStar (id) {
    State.store.commit('posts/addStar', id)
  },

  pullStar (id) {
    State.store.commit('posts/pullStar', id)
  },

  markPollVoted (data) {
    State.store.commit('posts/markPollVoted', data)
  },

  collectCommentNextPage (id) {
    return State.store.getters['posts/collectCommentNextPage'](id)
  },

  replaceCommentNextPage (id, nextPage) {
    const payload = { id, nextPage }
    return State.store.commit('posts/replaceCommentNextPage', payload)
  },

  collectComments (id) {
    return State.store.getters['posts/collectComments'](id)
  },

  replaceComments (id, comments) {
    const payload = { id, comments }
    State.store.commit('posts/replaceComments', payload)
  },

  upvoteComment (comment) {
    State.store.commit('posts/upvoteComment', comment)
  },

  unvoteComment (comment) {
    State.store.commit('posts/unvoteComment', comment)
  },

  removeFavourited (id) {
    State.store.commit('posts/removeFavourited', id)
  },

  clearArticleEditor () {
    State.store.commit('posts/clearArticleEditor')
  }
}
