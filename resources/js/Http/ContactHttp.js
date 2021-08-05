import Http from './Http'

export default {
  contact (data) {
    return Http.post('contact', data)
  }
}
