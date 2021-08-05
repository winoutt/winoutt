import { isEmpty } from 'lodash'
import UserStatusHttp from '../Http/UserStatusHttp'
import UserState from '../State/UserState'

export default {
  async update (isOnline) {
    const user = await UserStatusHttp.update(isOnline)
    if (isEmpty(user)) return
    UserState.updateStatus(user.id, isOnline)
  }
}
