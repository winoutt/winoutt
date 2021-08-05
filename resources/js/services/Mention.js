import v from 'voca'
import { last, filter } from 'lodash'

export default {
  isLastWordIsMention (text) {
    const toWords = v.split(text, ' ')
    const lastWord = last(toWords)
    return v.includes(lastWord, '@')
  },

  lastMention (text) {
    const toWords = v.split(text, ' ')
    const mentions = filter(toWords, word => v.includes(word, '@'))
    return last(mentions)
  },

  getTerm (text) {
    return v.replace(this.lastMention(text), '@', '')
  }
}
