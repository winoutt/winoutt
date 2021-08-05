import Http from './Http'

export default {
  create (data) {
    return Http.post('poll/votes', data)
  }
}
