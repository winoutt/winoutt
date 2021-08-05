<template lang="pug">
  ReportModal#comment-report-modal(
    type="comment"
    @cancel="cancel()"
    @report="report()"
    :data="comment"
  )
</template>

<script lang="ts">
import Vue from 'vue'
import CommentModalService from '../../services/ModalServices/CommentModalService'
import ReportModal from '../modal/ReportModal.vue'
import CommentState from '../../State/CommentState'

export default Vue.extend({
  components: {
    ReportModal
  },

  computed: {
    comment () {
      return CommentState.collectComment()
    }
  },

  methods: {
    cancel () {
      CommentModalService.report().close()
    },
    report () {
      CommentModalService.report().close()
    }
  }
})
</script>
