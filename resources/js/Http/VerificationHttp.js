import Http from './Http'

export default {
  resend (data) {
    return Http.post('verification/resend', data)
  },

  verify (data) {
    return Http.post('verification/verify', data)
  }
}
