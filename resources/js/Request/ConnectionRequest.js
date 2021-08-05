import { isEmpty } from 'lodash'
import ConnectionHttp from '../Http/ConnectionHttp'
import UserState from '../State/UserState'
import Alert from '../services/Alert'
import UserModalService from '../services/ModalServices/UserModalService'

export default {
  async create (user, message) {
    const data = {
      userId: user.id,
      message
    }
    const { isRequested } = await ConnectionHttp.create(data)
    if (!isRequested) return
    UserState.markRequested(data.userId)
    return isRequested
  },

  async accept (id) {
    const response = await ConnectionHttp.accept(id)
    const { isAccepted } = response
    if (!isAccepted) return
    UserState.markAccepted(id)
    Alert.success('Connection request accepted')
    return response
  },

  async ignore (id) {
    const response = await ConnectionHttp.ignore(id)
    const { isIgnored } = response
    if (!isIgnored) return
    UserState.markIgnored(id)
    Alert.success('Connection request ignored')
    return response
  },

  async mutuals (user, nextPage = false) {
    if (nextPage === null) return
    const mutuals = await ConnectionHttp.mutuals(user.id, nextPage)
    if (isEmpty(mutuals)) return
    if (nextPage) UserState.pushMutuals(mutuals)
    else {
      UserState.replaceMutuals(mutuals)
      UserState.replaceMutualsModal(user)
    }
    UserModalService.mutualConnections().open()
    return mutuals
  },

  async list (user, nextPage = false) {
    if (nextPage === null) return
    const connections = await ConnectionHttp.list(user.id, nextPage)
    if (isEmpty(connections)) return
    if (nextPage) UserState.pushConnections(connections)
    else {
      UserState.replaceConnections(connections)
      UserState.replaceConnectionsModal(user)
    }
    UserModalService.connections().open()
    return connections
  },

  async disconnect (id) {
    const { isDisconnected } = await ConnectionHttp.disconnect(id)
    if (!isDisconnected) return
    UserState.markDisconnected(id)
  },

  async cancel (id) {
    const { isCanceled } = await ConnectionHttp.cancel(id)
    if (!isCanceled) return
    UserState.markCanceled(id)
  }
}
