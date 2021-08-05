import Http from './Http'

export default {
  archive (id) {
    return Http.delete(`chats/${id}/archive`)
  },

  unarchive (id) {
    return Http.post(`chats/${id}/unarchive`)
  },

  paginate (nextPage = null) {
    const baseUrl = 'chats/paginate'
    const url = nextPage || baseUrl
    return Http.get(url)
  },

  archived (nextPage = null) {
    const baseUrl = 'chats/archived'
    const url = nextPage ? `${baseUrl}/${nextPage}` : baseUrl
    return Http.get(url)
  },

  search (params) {
    return Http.get('chats/search', params)
  },

  read (id) {
    return Http.post(`chats/${id}/read`)
  },

  markDelivered () {
    return Http.post('chats/mark/delivered')
  },

  readFromUserId (id) {
    return Http.get(`chats/user/${id}`)
  }
}
