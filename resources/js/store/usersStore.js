import { find, forEach, isEmpty, every, compact, isMatch } from 'lodash'

function findAll (state, id) {
  const user = isMatch(state.user, { id }) ? state.user : null
  const profile = isMatch(state.profile, { id }) ? state.profile : null
  const modal = isMatch(state.modal, { id }) ? state.modal : null
  const users = find(state.users, { id })
  const search = find(state.search.data, { id })
  const mutuals = find(state.mutuals.data, { id })
  const connections = find(state.connections.data, { id })
  const postStars = find(state.postStars.data, { id })
  const postMentions = find(state.postMentions, { id })
  const commentMentions = find(state.commentMentions.data, { id })
  return compact([
    user,
    profile,
    modal,
    users,
    search,
    mutuals,
    connections,
    postStars,
    postMentions,
    commentMentions
  ])
}

function findAllAndUpdate (state, id, updates) {
  const updatables = findAll(state, id)
  forEach(updatables, user => {
    forEach(updates, (value, key) => { user[key] = value })
  })
}

export default {
  namespaced: true,
  state: {
    user: {
      firstName: '',
      lastName: '',
      username: '',
      email: '',
      bio: '',
      website: {
        company: '',
        personal: ''
      },
      dateOfBirth: '',
      gender: '',
      city: '',
      country: '',
      avatar: '',
      sessionAt: ''
    },
    profile: {},
    modal: {},
    mutualsModal: {},
    connectionsModal: {},
    connectionRequestModal: {},
    users: [],
    search: {
      reference: '',
      data: []
    },
    mutuals: {
      data: [],
      next_page_url: null
    },
    connections: {
      data: [],
      next_page_url: null
    },
    postStars: {
      data: [],
      next_page_url: null
    },
    postMentions: [],
    commentMentions: {
      data: [],
      post_id: ''
    },
    nextPage: ''
  },

  mutations: {
    replaceUser (state, user) {
      state.user = user
    },
    replaceProfile (state, profile) {
      state.profile = profile
    },
    replaceModal (state, user) {
      state.modal = user
    },
    replaceMutualsModal (state, user) {
      state.mutualsModal = user
    },
    replaceConnectionsModal (state, user) {
      state.connectionsModal = user
    },
    replaceConnectionRequestModal (state, user) {
      state.connectionRequestModal = user
    },
    replaceUsers (state, users) {
      state.users = users
    },
    replaceSearch (state, payload) {
      const { reference, users } = payload
      state.search.reference = reference
      state.search.data = users
    },
    replaceMutuals (state, mutuals) {
      state.mutuals.data = mutuals.data
      state.mutuals.next_page_url = mutuals.next_page_url
    },
    replaceConnections (state, connections) {
      state.connections.data = connections.data
      state.connections.next_page_url = connections.next_page_url
    },
    replaceNextPage (state, nextPage) {
      state.nextPage = nextPage
    },
    replacePostStars (state, stars) {
      state.postStars.data = stars.data
      state.postStars.next_page_url = stars.next_page_url
    },
    replacePostMentions (state, suggestions) {
      state.postMentions = suggestions
    },
    replaceCommentMentions (state, payload) {
      const { postId, suggestions } = payload
      state.commentMentions.data = suggestions
      state.commentMentions.post_id = postId
    },
    pushUsers (state, users) {
      forEach(users, user => state.users.push(user))
    },
    pushPostStars (state, stars) {
      forEach(stars.data, user => state.postStars.data.push(user))
      state.postStars.next_page_url = stars.next_page_url
    },
    pushMutuals (state, mutuals) {
      forEach(mutuals.data, mutual => {
        state.mutuals.data.push(mutual)
      })
      state.mutuals.next_page_url = mutuals.next_page_url
    },
    pushConnections (state, connections) {
      forEach(connections.data, connection => {
        state.connections.data.push(connection)
      })
      state.connections.next_page_url = connections.next_page_url
    },
    pullUser (state) {
      state.user = {}
    },
    markRequested (state, id) {
      findAllAndUpdate(state, id, { is_requested: true })
    },
    markAccepted (state, id) {
      findAllAndUpdate(state, id, { is_connected: true, is_received: false })
    },
    markIgnored (state, id) {
      findAllAndUpdate(state, id, { is_received: false })
    },
    markDisconnected (state, id) {
      findAllAndUpdate(state, id, { is_connected: false })
    },
    markCanceled (state, id) {
      findAllAndUpdate(state, id, { is_requested: false })
    },
    markFollowed (state, id) {
      findAllAndUpdate(state, id, { is_unfollowed: false })
    },
    markUnfollowed (state, id) {
      findAllAndUpdate(state, id, { is_unfollowed: true })
    },
    incrementPostsCount (state, id) {
      const updatables = findAll(state, id)
      forEach(updatables, user => user.posts_count++)
    },
    decrementPostsCount (state, id) {
      const updatables = findAll(state, id)
      forEach(updatables, user => user.posts_count--)
    },
    updateStatus (state, payload) {
      const { id, isOnline } = payload
      findAllAndUpdate(state, id, { is_online: isOnline })
    }
  },

  getters: {
    user: state => state.user,
    profile: state => state.profile,
    modal: state => state.modal,
    users: state => state.users,
    search: state => {
      return reference => {
        if (state.search.reference === reference) {
          return state.search.data
        }
      }
    },
    mutuals: state => state.mutuals,
    mutualsModal: state => state.mutualsModal,
    connections: state => state.connections,
    connectionsModal: state => state.connectionsModal,
    connectionRequestModal: state => state.connectionRequestModal,
    collectIsProfileCompleted: state => {
      const user = state.user
      const completables = [
        user.bio,
        user.date_of_birth,
        user.gender,
        user.city,
        user.country,
        user.title
      ]
      return every(completables, completable => !isEmpty(completable))
    },
    postStars: state => state.postStars.data,
    postMentions: state => state.postMentions,
    commentMentions: state => state.commentMentions,
    postStarsNextPage: state => state.postStars.next_page_url
  }
}
