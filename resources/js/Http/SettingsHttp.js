import Http from './Http'

export default {
  update (data) {
    return Http.put('settings', data)
  }
}
