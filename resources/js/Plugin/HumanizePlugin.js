import moment from 'moment'
import Abbreviate from 'number-abbreviate'
import { forEach, replace } from 'lodash'

export default {
  humanize: {
    fromNow (data) {
      return moment(data).fromNow()
    },
    count (number) {
      return Abbreviate(number)
    },
    url (url) {
      const removables = ['https://', 'http://', 'www.']
      forEach(removables, removable => { url = replace(url, removable, '') })
      return url
    }
  },
  install (Vue) {
    Vue.prototype.Humanize = this.humanize
  }
}
