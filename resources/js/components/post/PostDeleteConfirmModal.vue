<template lang="pug">
  ConfirmModal#post-delete-confirm-modal(
    title="Delete post"
    @confirm="remove()"
    @cancel="cancel()"
  )
    p.disconnect
      | Are you sure you want to delete this post?
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import PostState from '../../State/PostState'
import PostRequest from '../../Request/PostRequest'

import ConfirmModal from '../modal/ConfirmModal.vue'

export default Vue.extend({
  components: {
    ConfirmModal
  },

  computed: {
    post () {
      return PostState.collectPost()
    }
  },

  methods: {
    closeModal () {
      PostModalService.deleteConfirm().close()
    },
    async remove () {
      const response = PostRequest.delete(this.post)
      if (!response) return
      this.closeModal()
    },
    cancel () {
      this.closeModal()
    }
  }
})
</script>
