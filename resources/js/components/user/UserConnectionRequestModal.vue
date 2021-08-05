<template lang="pug">
  Modal#user-connection-request-modal(title="Send a connection request")
    template(v-slot:body)
      .connection-request
        p When requesting to connect, you always want to write a personal note.
        .form-group
          label.font-weight-bold Message (optional)
          Textarea(
            placeholder="e.g., I'm really impressed with your background and would very much like to learn more about your career path. I hope you'll consider connecting."
            rows="3"
            v-model="message"
          )
        h6.font-weight-bold Personal note components:
        ul
          li How you know them, know about them, or found them
          li Tell who you are and why you'd like to connect
          li Warm, polite and end note
    template(v-slot:footer)
      .footer.d-flex.justify-content-end
        Button.mr-2(text="Cancel" :secondary="true" @click.native="cancel()")
        Button(text="Send request" @click.native="connect()")
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../State/UserState'
import ConnectionRequest from '../../Request/ConnectionRequest'
import UserModalService from '../../services/ModalServices/UserModalService'

import Modal from '../modal/Modal.vue'
import Textarea from '../Textarea.vue'
import Button from '../button/Button.vue'

export default Vue.extend({
  components: {
    Modal,
    Textarea,
    Button
  },

  computed: {
    user () {
      return UserState.collectConnectionRequestModal()
    }
  },

  data () {
    return {
      message: ''
    }
  },

  methods: {
    close () {
      UserModalService.connectionRequest().close()
    },
    cancel () {
      this.close()
    },
    async connect () {
      await ConnectionRequest.create(this.user, this.message)
      this.close()
    },
    onClose () {
      UserModalService.connectionRequest().onClose(() => {
        this.message = ''
      })
    }
  },

  mounted () {
    this.onClose()
  }
})
</script>
