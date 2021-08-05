<template lang="pug">
  Modal#settings-crop-avatar-modal(title="Edit avatar" :large="true")
    template(v-slot:body)
      .cropper
        img#cropper-image(:src="avatar.uri")
    template(v-slot:footer)
      .actions.d-flex.justify-content-end
        Button.mr-2(text="Cancel" :secondary="true" @click.native="cancel()")
        Button(text="Apply" @click.native="edit()")
</template>

<script lang="ts">
import Vue from 'vue'
import Cropperjs from 'cropperjs'
import SettingsModalService from '../../../services/ModalServices/SettingsModalService'

import Modal from '../../modal/Modal.vue'
import Button from '../../button/Button.vue'

export default Vue.extend({
  props: ['avatar'],
  components: {
    Modal,
    Button
  },

  data () {
    return {
      cropper: null
    }
  },

  methods: {
    initCropper () {
      const element = document.getElementById('cropper-image')
      this.cropper = new Cropperjs(element, {
        aspectRatio: 1 / 1
      })
    },
    onOpen () {
      SettingsModalService.cropAvatar().onOpen(() => {
        this.cropper.replace(this.avatar.uri)
      })
    },
    cancel () {
      SettingsModalService.cropAvatar().close()
    },
    edit () {
      const canvasElement = this.cropper.getCroppedCanvas()
      const uri = canvasElement.toDataURL('image/jpeg', 0.8)
      this.$emit('change', uri)
      SettingsModalService.cropAvatar().close()
    }
  },

  mounted () {
    this.initCropper()
    this.onOpen()
  }
})
</script>

<style lang="sass" scoped>
.cropper
  max-width: 100%
#cropper-image
  max-width: 100%
</style>
