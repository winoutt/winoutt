import store from '../store'

export default {
  store: {},
  boot () {
    this.store = store
  }
}
