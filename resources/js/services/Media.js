import { includes, every, toLower } from 'lodash'
import Alert from '../services/Alert'

export default {
  types: {
    image: ['jpg', 'jpeg', 'png'],
    audio: ['mp3', 'wav'],
    video: ['mp4']
  },

  sizes: {
    image: 3,
    video: 25,
    audio: 5,
    document: 20
  },

  isValidSize (file, type, size) {
    return file.size <= ((size || this.sizes[type]) * 1024 * 1024)
  },

  isValidType (type, file) {
    return includes(this.types[type], toLower(file.extension))
  },

  isValidPhoto (file, size) {
    const isValidPhoto = this.isValidType('image', file)
    if (!isValidPhoto) {
      Alert.error('Unsupported image selected')
      return isValidPhoto
    }
    const isValidSize = this.isValidSize(file, 'image', size)
    if (!isValidSize) Alert.error(`The image size is greater than ${size || this.sizes.image} MB`)
    return isValidSize
  },

  isValidPhotos (files) {
    return every(files, file => this.isValidPhoto(file))
  },

  isValidAudio (file) {
    const isValidAudio = this.isValidType('audio', file)
    if (!isValidAudio) {
      Alert.error('Unsupported audio selected')
      return isValidAudio
    }
    const isValidSize = this.isValidSize(file, 'audio')
    if (!isValidSize) Alert.error(`The audio size is greater than ${this.sizes.audio} MB`)
    return isValidSize
  },

  isValidVideo (file) {
    const isValidVideo = this.isValidType('video', file)
    if (!isValidVideo) {
      Alert.error('Unsupported video selected')
      return isValidVideo
    }
    const isValidSize = this.isValidSize(file, 'video')
    if (!isValidSize) Alert.error(`The video size is greater than ${this.sizes.video} MB`)
    return isValidSize
  },

  isValidDocument (file) {
    const isValidSize = this.isValidSize(file, 'document')
    if (!isValidSize) Alert.error(`The document size is greater than ${this.sizes.document} MB`)
    return isValidSize
  },

  isValidFile (file) {
    const type = this.type(file)
    if (type === 'image') return this.isValidPhoto(file)
    else if (type === 'audio') return this.isValidAudio(file)
    else if (type === 'video') return this.isValidVideo(file)
    else return this.isValidDocument(file)
  },

  type (file) {
    if (this.isValidType('image', file)) return 'image'
    else if (this.isValidType('audio', file)) return 'audio'
    else if (this.isValidType('video', file)) return 'video'
    else return 'document'
  }
}
