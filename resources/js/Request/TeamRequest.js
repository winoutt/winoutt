import { isEmpty } from 'lodash'
import TeamHttp from '../Http/TeamHttp'
import TeamState from '../State/TeamState'
import UserState from '../State/UserState'
import PostState from '../State/PostState'
import Router from '../services/Router'

export default {
  async list () {
    const teams = await TeamHttp.list()
    if (isEmpty(teams)) return
    TeamState.replaceTeams(teams)
    return teams
  },

  async top () {
    const teams = await TeamHttp.top()
    if (isEmpty(teams)) return
    TeamState.replaceTop(teams)
    return teams
  },

  async read (slug) {
    const team = await TeamHttp.read(slug)
    if (isEmpty(team)) return Router.router.push({ name: 'NotFound' })
    TeamState.replaceTeam(team)
    return team
  },

  async contributors (id) {
    const contributors = await TeamHttp.contributors(id)
    if (isEmpty(contributors)) return
    UserState.replaceUsers(contributors)
    return contributors
  },

  async posts (id, nextPage = false) {
    if (nextPage === null) return
    const posts = await TeamHttp.posts(id, nextPage)
    if (isEmpty(posts)) return
    if (nextPage) PostState.pushPosts(posts.data)
    else PostState.replacePosts(posts.data)
    PostState.replaceNextPage(posts.next_page_url)
    return posts
  }
}
