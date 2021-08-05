<template lang="pug">
  .post-modals
    PostShareModal
    PostReportModal
    PostStarredModal
    PostDeleteConfirmModal
    CommentModals
    ArticleReadModal
</template>

<script lang="ts">
import Vue from 'vue'
import PostShareModal from './PostShareModal.vue'
import PostStarredModal from './PostStarredModal.vue'
import PostReportModal from './PostReportModal.vue'
import PostDeleteConfirmModal from './PostDeleteConfirmModal.vue'
import CommentModals from '../comment/CommentModals.vue'
import ArticleReadModal from '../article/ArticleReadModal.vue'

export default Vue.extend({
  components: {
    PostShareModal,
    PostStarredModal,
    PostReportModal,
    PostDeleteConfirmModal,
    CommentModals,
    ArticleReadModal
  }
})
</script>
