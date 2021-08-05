<template lang="pug">
  .input-image(:class="[circle ? 'circle' : '', type]")
    input(id="image-input" type="file" accept=".jpg,.jpeg,.png" hidden @change="upload($event)")
    .image-wrapper.position-relative.d-inline-box.m-auto.cursor-pointer(@click="clickOnInput()")
      img(v-if="preview" :src="preview")
      .content.position-absolute.d-flex.flex-column.h-100.justify-content-center.align-items-center
        Icon.icon-upload.mb-2(name="upload" :style="preview ? 'fill: white;' : ''")
        p.mb-0(:class="preview ? 'text-white' : ''") {{ placeholder }}
</template>

<script lang="ts">
import Vue from 'vue'
import $ from 'jquery'
import UploadService from '../../services/UploadService'
import Media from '../../services/Media'

import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['default', 'value', 'circle', 'text', 'type', 'size'],
  components: {
    Icon
  },

  data () {
    return {
      defaultImage: '',
      image: ''
    }
  },

  watch: {
    value: function (newValue) {
      if (!newValue) this.image = ''
    }
  },

  computed: {
    preview () {
      this.updateDefaultImage()
      return this.defaultImage || this.image
    },
    placeholder () {
      const startText = this.preview ? 'Change' : 'Add'
      return this.text ? `${startText} ${this.text}` : startText
    }
  },

  methods: {
    clickOnInput: () => $('#image-input').click(),
    async upload (event) {
      const file = await UploadService.file(event)
      if (!Media.isValidPhoto(file, this.size)) return
      this.image = file.uri
      this.defaultImage = ''
      this.$emit('change', file)
    },
    updateDefaultImage () {
      this.defaultImage = this.default
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.input-image
  .image-wrapper
    width: 100%
    height: 100%
    background: #efefef
    border-radius: 8px
    img
      width: 100%
      height: 100%
      object-fit: cover
      transition: 0.5s
      border-radius: 8px
    .content
      top: 50%
      left: 50%
      transform: translate(-50%, -50%)
      .icon-upload
        width: 18px
        height: 18px
      p
        font-size: 0.75rem
    &:hover
      img
        filter: brightness(40%)
  &.circle
    .image-wrapper, img
      border-radius: 50%
.fixed
  .image-wrapper
    img
      filter: brightness(50%)
    &:hover
      img
        filter: brightness(50%)
    .icon-upload
      filter: drop-shadow(0px 0px 3px #000000)
    .content
      text-shadow: 0px 0px 5px #000000
</style>
