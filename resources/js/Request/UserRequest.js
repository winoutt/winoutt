import { isEmpty, cloneDeep } from 'lodash'
import UserHttp from '../Http/UserHttp'
import UserState from '../State/UserState'
import AuthToken from '../services/AuthToken'
import SessionAlert from '../services/SessionAlert'
import Router from '../services/Router'
import PostState from '../State/PostState'
import SettingsModalService from '../services/ModalServices/SettingsModalService'
import Alert from '../services/Alert'
import SettingsState from '../State/SettingsState'

export default {
  async read (username) {
    const user = await UserHttp.read(username)
    if (isEmpty(user)) return Router.router.push({ name: 'NotFound' })
    UserState.replaceProfile(user)
    return user
  },

  async edit (data) {
    const user = await UserHttp.edit(data)
    if (isEmpty(user)) return
    UserState.replaceUser(user)
    SettingsState.replaceUser(cloneDeep(user)) // Clone to avoid object reference
    Alert.success('Your settings have been saved.')
  },

  async delete (data) {
    const { isDeleted } = await UserHttp.delete(data)
    if (!isDeleted) return
    SettingsModalService.deleteAccount().close()
    AuthToken.remove()
    SessionAlert.shutdown()
    UserState.pullUser()
    Router.router.push({ name: 'AccountDelete' })
  },

  async posts (username, nextPage = false) {
    if (nextPage === null) return
    const posts = await UserHttp.posts(username, nextPage)
    if (isEmpty(posts)) return
    if (nextPage) PostState.pushPosts(posts.data)
    else PostState.replacePosts(posts.data)
    PostState.replaceNextPage(posts.next_page_url)
  }
}
