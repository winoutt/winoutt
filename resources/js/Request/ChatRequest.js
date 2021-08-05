import { isEmpty } from 'lodash'
import ChatHttp from '../Http/ChatHttp'
import ChatState from '../State/ChatState'
import MessageState from '../State/MessageState'

export default {
  async archive (chat) {
    const { isArchived } = await ChatHttp.archive(chat.pivot.id)
    if (!isArchived) return
    MessageState.pullUnreadsCount(chat.unreads_count)
    ChatState.pullActive(chat.id)
    ChatState.addArchived(chat)
    MessageState.pullMessages()
    ChatState.pullChat()
  },

  async unarchive (chat) {
    const { isUnarchived } = await ChatHttp.unarchive(chat.pivot.id)
    if (!isUnarchived) return
    ChatState.pullArchived(chat.id)
    ChatState.addActive(chat)
    MessageState.pullMessages()
    ChatState.pullChat()
    MessageState.addUnreadsCount(chat.unreads_count)
  },

  async paginate (nextPage = false) {
    if (nextPage === null) return
    const chats = await ChatHttp.paginate(nextPage)
    if (isEmpty(chats)) return
    if (nextPage) ChatState.pushActive(chats.data)
    else ChatState.replaceActive(chats.data)
    ChatState.replaceNextPage(chats.next_page_url)
    return chats
  },

  async archived (nextPage = false) {
    if (nextPage === null) return
    const chats = await ChatHttp.archived(nextPage)
    if (isEmpty(chats)) return
    if (nextPage) ChatState.pushArchived(chats.data)
    else ChatState.replaceArchived(chats.data)
    ChatState.replaceNextPage(chats.next_page_url)
    return chats
  },

  async search (params) {
    const search = await ChatHttp.search(params)
    if (isEmpty(search)) ChatState.replaceActive([])
    else ChatState.replaceActive(search)
  },

  async read (id) {
    const { isRead } = await ChatHttp.read(id)
    if (!isRead) return
    ChatState.readChat(id)
    MessageState.readMessages(id)
  },

  markDelivered () {
    return ChatHttp.markDelivered()
  },

  async readFromUserId (id) {
    const chat = await ChatHttp.readFromUserId(id)
    if (isEmpty(chat)) return
    ChatState.activateChat(chat)
    return chat
  }
}
