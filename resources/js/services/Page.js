import { includes } from 'voca'

export default {
  is (path) {
    const { pathname } = window.location
    return includes(pathname, path)
  }
}
