import { last, split, includes } from 'lodash'
import { indexOf, count } from 'voca'

export default {
  isValid (url) {
    const hasDot = includes(url, '.')
    const hasTld = last(split(url, '.'))
    return hasDot && hasTld
  },

  getUrlPosition(content, linkPreview) {
    if (!linkPreview || !linkPreview.url) return 'top'
    const { url } = linkPreview
    const index = indexOf(content, url)
    const contentSize = count(content) - count(url)
    const isTop = (contentSize / 2) >= index
    return isTop ? 'top' : 'bottom'
  }
}
