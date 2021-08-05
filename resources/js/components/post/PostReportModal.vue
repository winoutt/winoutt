<template lang="pug">
  ReportModal#post-report-modal(
    type="post"
    @cancel="cancel()"
    @report="report()"
    :data="post"
  )
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import ReportModal from '../modal/ReportModal.vue'
import PostState from '../../State/PostState'

export default Vue.extend({
  components: {
    ReportModal
  },

  computed: {
    post () {
      return PostState.collectPost()
    }
  },

  methods: {
    cancel () {
      PostModalService.report().close()
    },
    report () {
      PostModalService.report().close()
    }
  }
})
</script>
