import Http from './Http'

export default {
  read (messageId) {
    return Http.get(`messages/${messageId}`)
  },

  create (data) {
    return Http.post('messages', data)
  },

  paginate (chatId, nextPage = false) {
    if (nextPage) return Http.paginate(nextPage)
    return Http.get(`messages/${chatId}/paginate`)
  },

  unreadsCount () {
    return Http.get('messages/unreads/count')
  }
}
