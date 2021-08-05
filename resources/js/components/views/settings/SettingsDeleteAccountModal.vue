<template lang="pug">
  Modal#settings-delete-account-modal(title="Are you sure you want to delete your account?")
    template(v-slot:body)
      .row.no-gutters
        .col-md-72
          .form-group
            label.font-weight-bold Confirm username
            Input(placeholder="Username" v-model="username")
    template(v-slot:footer)
      .actions.d-flex.justify-content-end
        Button.align-self-center.mr-2(text="Cancel" :secondary="true" @click.native="close()")
        Button.mt-0(text="Delete" @click.native="deleteAccount()")
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsModalService from '../../../services/ModalServices/SettingsModalService'
import UserRequest from '../../../Request/UserRequest'

import Modal from '../../modal/Modal.vue'
import Input from '../../input/Input.vue'
import Button from '../../button/Button.vue'

export default Vue.extend({
  components: {
    Modal,
    Input,
    Button
  },

  data () {
    return {
      username: ''
    }
  },

  methods: {
    deleteAccount () {
      const data = { username: this.username }
      UserRequest.delete(data)
    },
    close () {
      SettingsModalService.deleteAccount().close()
    }
  }
})
</script>
