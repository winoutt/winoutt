import { isEmpty } from 'lodash'
import PeopleHttp from '../Http/PeopleHttp'
import UserState from '../State/UserState'
import AuthToken from '../services/AuthToken'

export default {
  async mayknow () {
    if (!AuthToken.has()) return // Block for public pages
    const response = await PeopleHttp.mayknow()
    const peoples = isEmpty(response) ? [] : response
    UserState.replaceUsers(peoples)
    return peoples
  },

  async paginate (nextPage = false) {
    if (nextPage === null) return
    const peoples = await PeopleHttp.paginate(nextPage)
    if (isEmpty(peoples)) return
    if (nextPage) UserState.pushUsers(peoples)
    else UserState.replaceUsers(peoples.data)
    UserState.replaceNextPage(peoples.next_page_url)
    return peoples
  },

  async search (params) {
    const peoples = await PeopleHttp.search(params)
    if (isEmpty(peoples)) return
    UserState.replaceSearch(params.reference, peoples)
    return peoples
  }
}
