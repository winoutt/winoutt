<template lang="pug">
  Modal#post-share-modal(title="Share post")
    template(v-slot:body)
      .shares.mb-2.d-flex.py-3
        a.share.cursor-pointer(
          v-for="share in shares"
          :href="share.url"
          target="_blank"
        )
          Icon.icon.mr-3(:name="share.sharer")
        .copy.d-flex.align-items-center
          Icon.icon.cursor-pointer(name="files-active" @click.native="copyUrl()")
      Input(v-model="postUrl" :id="`copy-input-${post.id}`" readonly)
    template(v-slot:footer)
      Button.ml-auto.d-block(text="Done" @click.native="done()")
</template>

<script lang="ts">
import Vue from 'vue'
import $ from 'jquery'
import PostModalService from '../../services/ModalServices/PostModalService'
import AlertState from '../../State/AlertState'

import Modal from '../modal/Modal.vue'
import Icon from '../Icon.vue'
import Input from '../input/Input.vue'
import Button from '../button/Button.vue'
import PostState from '../../State/PostState'

export default Vue.extend({
  components: {
    Modal,
    Icon,
    Input,
    Button
  },

  computed: {
    post () {
      return PostState.collectPost()
    },
    postUrl () {
      const route = { name: 'Post', params: { id: this.post.id } }
      const { href } = this.$router.resolve(route)
      return `${process.env.MIX_APP_URL}${href}`
    },
    shares () {
      const caption = this.post.caption ? this.post.caption : ''
      return [
        {
          sharer: 'twitter',
          url: `https://twitter.com/intent/tweet?url=${this.postUrl}&text=${caption}`
        },
        {
          sharer: 'facebook',
          url: `https://www.facebook.com/sharer.php?u=${this.postUrl}&quote=${caption}`
        },
        {
          sharer: 'linkedin',
          url: `https://www.linkedin.com/shareArticle?mini=true&url=${this.postUrl}&title=${caption}`
        }
      ]
    }
  },

  methods: {
    done () {
      PostModalService.share().close()
    },
    copyUrl () {
      const inputDom = $(`#copy-input-${this.post.id} input`)
      inputDom.select()
      document.execCommand('copy')
      window.getSelection().removeAllRanges()
      const alert = {
        type: 'success',
        message: 'Copied link'
      }
      AlertState.replaceAlert(alert)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.shares
  .icon
    width: 30px
    height: 30px
    transition: 0.4s
    &:hover
      fill: $primary
  .copy
    .icon
      height: 28px
</style>
