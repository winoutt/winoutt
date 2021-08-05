import Http from './Http'

export default {
  update (isOnline) {
    const data = { is_online: isOnline }
    return Http.post('users/status', data)
  }
}
