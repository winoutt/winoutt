import { isEmpty } from 'lodash'
import SearchHttp from '../Http/SearchHttp'
import HashtagState from '../State/HashtagState'
import UserState from '../State/UserState'
import PostState from '../State/PostState'
import Router from '../services/Router'
import SearchState from '../State/SearchState'

export default {
  async all () {
    const term = SearchState.collectTerm()
    if (!term) {
      Router.router.back()
      return
    }
    const result = await SearchHttp.all({ term })
    if (isEmpty(result)) return
    const { hashtags, people, posts } = result
    HashtagState.replaceSearch(hashtags)
    UserState.replaceSearch('global-search', people)
    PostState.replacePosts(posts)
    const isSearchPage = Router.router.currentRoute.name === 'Search'
    if (!isSearchPage) Router.router.push({ name: 'Search' })
  }
}
