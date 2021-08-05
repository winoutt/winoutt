import { map } from 'lodash'

export default {
  parse: function (event) {
    const sources = event.target.files
    const source = sources.length ? sources[0] : null
    return source
  },

  parseMultiple: function (event) {
    const sources = event.target.files
    return sources.length ? sources : null
  },

  name: function (source) {
    const name = source.name
    const canShorten = name.length >= 18
    const shorten = canShorten ? name.substr(0, 15) + '...' : name
    return shorten
  },

  extension: function (source) {
    const extension = source.name.split('.').pop()
    return extension
  },

  transform: function (source, uri) {
    const name = this.name(source)
    const extension = this.extension(source)
    const result = { name, uri, extension, size: source.size }
    return result
  },

  read: function (source) {
    return new Promise((resolve, reject) => {
      const fileReader = new FileReader()
      fileReader.readAsDataURL(source)
      fileReader.addEventListener('load', event => {
        resolve(event.target.result)
      })
    })
  },

  file: async function (event) {
    const source = this.parse(event)
    event.target.value = ''
    const uri = await this.read(source)
    return this.transform(source, uri)
  },

  fileMultiple: async function (event) {
    const sources = Array.from(this.parseMultiple(event))
    event.target.value = ''
    const bulkRead = map(sources, async source => {
      const uri = await this.read(source)
      return this.transform(source, uri)
    })
    return Promise.all(bulkRead)
  }
}
