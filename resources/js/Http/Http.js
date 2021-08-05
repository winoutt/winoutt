import axios from 'axios'
import { replace } from 'voca'
import Alert from '../services/Alert'
import Progress from '../services/Progress'
import AuthToken from '../services/AuthToken'
import Router from '../services/Router'

export default {
  instance () {
    return axios.create({
      baseURL: `${process.env.MIX_APP_URL}/api`,
      headers: {
        Authorization: `Bearer ${AuthToken.token()}`,
        common: { 'X-Requested-With': 'XMLHttpRequest' }
      }
    })
  },

  errorHandler (error) {
    Progress.end()
    const { data, status } = error.response
    const isUnauthorized = status === 401
    const isLimitExceeded = status === 429
    const isNotFound = status === 404
    if (isUnauthorized) {
      Router.router.push({ name: 'SignIn' })
      Alert.error('Please sign in')
    } else if (isLimitExceeded || isNotFound) {
      return {}
    } else if (data) Alert.error(data.message)
    return {}
  },

  async get (url, params) {
    try {
      Progress.start()
      const config = { params }
      const response = await this.instance().get(url, config)
      Progress.end()
      return response.data
    } catch (error) {
      return this.errorHandler(error)
    }
  },

  async post (url, data) {
    try {
      Progress.start()
      const response = await this.instance().post(url, data)
      Progress.end()
      return response.data
    } catch (error) {
      return this.errorHandler(error)
    }
  },

  async put (url, data) {
    try {
      Progress.start()
      const response = await this.instance().put(url, data)
      Progress.end()
      return response.data
    } catch (error) {
      return this.errorHandler(error)
    }
  },

  async patch (url, data) {
    try {
      Progress.start()
      const response = await this.instance().patch(url, data)
      Progress.end()
      return response.data
    } catch (error) {
      return this.errorHandler(error)
    }
  },

  async delete (url) {
    try {
      Progress.start()
      const response = await this.instance().delete(url)
      Progress.end()
      return response.data
    } catch (error) {
      return this.errorHandler(error)
    }
  },

  paginate (url) {
    const absoluteUrl = replace(url, `${process.env.MIX_APP_URL}/api`, '')
    return this.get(absoluteUrl)
  }
}
