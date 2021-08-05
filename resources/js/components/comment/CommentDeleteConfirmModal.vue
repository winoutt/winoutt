<template lang="pug">
  ConfirmModal#comment-delete-confirm-modal(title="Delete comment" @confirm="remove()" @cancel="cancel()")
    p Are you sure you want to delete this comment?
</template>

<script lang="ts">
import Vue from 'vue'
import { isEmpty } from 'lodash'
import CommentModalService from '../../services/ModalServices/CommentModalService'
import CommentState from '../../State/CommentState'

import ConfirmModal from '../modal/ConfirmModal.vue'
import CommentRequest from '../../Request/CommentRequest'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  computed: {
    comment () {
      return CommentState.collectComment()
    }
  },

  methods: {
    closeModal () {
      CommentModalService.deleteConfirm().close()
    },
    async remove () {
      const response = await CommentRequest.delete(this.comment.id)
      if (isEmpty(response)) return
      this.closeModal()
    },
    cancel () {
      this.closeModal()
    }
  }
})
</script>
