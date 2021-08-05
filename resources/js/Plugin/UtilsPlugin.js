import { groupBy, isEmpty, includes, split, forEach, some } from 'lodash'
import { truncate, replaceAll } from 'voca'
import moment from 'moment'

export default {
  Util: {
    /**
     * Convert text to linkified component with
     * hashtags, mention router links and remove link
     * preview url
     * @param {string} text
     * @returns {string}
    */
    linkify (text, previewUrl = null) {
      function hashtagify (text) {
        const replacer = '<router-link class="linkify-link" :to="{ name: \'HashtagResult\', params: { hashtag: \'$1\' } }">#$1</router-link>'
        return text.replace(/#(\w+)/g, replacer)
      }
      function mentionify (text) {
        const replacer = '<router-link class="linkify-link" :to="{ name: \'Profile\', params: { username: \'$1\' } }">@$1</router-link>'
        return text.replace(/@(\w+)/g, replacer)
      }
      function anchorify (text) {
        const regex = /(https?:\/\/[^\s]+)/g
        const urls = text.match(regex)
        forEach(urls, url => {
          const link = `<a href="${url}">${url}</a>`
          text = replaceAll(text, url, link)
        })
        return text
      }
      function removePreviewLink (text) {
        return previewUrl ? replaceAll(text, previewUrl, '') : text
      }
      text = hashtagify(text)
      text = mentionify(text)
      text = anchorify(text)
      text = removePreviewLink(text)
      const wrapper = `<span class="pre">${text}</span>`
      return wrapper
    },
    shorten: (text, length) => {
      return truncate(text, length)
    },
    groupByDate: (group) => {
      return groupBy(group, item => {
        const isToday = moment(item.created_at)
          .isSame(moment.now(), 'day')
        const isYesterday = moment(item.created_at)
          .isSame(moment().subtract(1, 'day'), 'day')
        const date = moment(item.created_at).format('Do MMM YYYY')
        if (isToday) return 'Today'
        else if (isYesterday) return 'Yesterday'
        else return date
      })
    },
    isEmpty: (data) => isEmpty(data),
    youtubeVideoId: (content) => {
      const url = {
        id (type) {
          if (!includes(content, this[type])) return
          const spaceAndNewlineRegexp = /&| |\n/gm
          return split(split(content, this[type])[1], spaceAndNewlineRegexp)[0]
        },
        classic: 'youtube.com/watch?v=',
        shorten: 'youtu.be/'
      }
      return url.id('classic') || url.id('shorten')
    },
    sanitizeUrl (url) {
      if (!url) return null
      const protocols = ['http://', 'https://']
      const hasProtocol = some(protocols, protocol => {
        return includes(url, protocol)
      })
      return hasProtocol ? url : `http://${url}`
    },
    date: {
      isEnded (date) {
        return moment().isAfter(moment(date))
      },
      monthAndYear (date) {
        return moment(date).format('MMMM YYYY')
      }
    }
  },

  install (Vue) {
    Vue.prototype.Util = this.Util
  }
}
