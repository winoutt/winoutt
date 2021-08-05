<template lang="pug">
  .comment-modals
    CommentDeleteConfirmModal
    CommentReportModal
</template>

<script lang="ts">
import Vue from 'vue'
import CommentDeleteConfirmModal from './CommentDeleteConfirmModal.vue'
import CommentReportModal from './CommentReportModal.vue'

export default Vue.extend({
  components: {
    CommentDeleteConfirmModal,
    CommentReportModal
  }
})
</script>
