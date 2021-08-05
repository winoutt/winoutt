import { some, isEmpty, isPlainObject } from 'lodash'

export default {
  async bulk (requests) {
    const responses = await Promise.all(requests)
    const isFailed = some(responses, response => {
      return isPlainObject(response) && isEmpty(response)
    })
    return { responses, isFailed }
  }
}
