import { findIndex, take, takeRight, size } from 'lodash'
import SliderState from '../State/SliderState'

export default {
  orderPhotos (photos, chosePhoto) {
    const choseIndex = findIndex(photos, { id: chosePhoto.id })
    const beforeChosePhoto = take(photos, choseIndex)
    const afterChosePhoto = takeRight(photos, (size(photos) - choseIndex - 1))
    return [chosePhoto, ...afterChosePhoto, ...beforeChosePhoto]
  },

  show (photos, chosePhoto = null) {
    photos = chosePhoto ? this.orderPhotos(photos, chosePhoto) : photos
    SliderState.replaceCanShow(true)
    SliderState.replacePhotos(photos)
  },

  hide () {
    SliderState.replaceCanShow(false)
    SliderState.pullPhotos()
  }
}
