<template lang="pug">
  ReportModal#user-report-modal(
    type="user"
    @cancel="cancel()"
    @report="report()"
    :data="profile"
  )
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../services/ModalServices/UserModalService'
import ReportModal from '../modal/ReportModal.vue'

export default Vue.extend({
  props: ['profile'],
  components: {
    ReportModal
  },

  methods: {
    cancel () {
      UserModalService.report().close()
    },
    report () {
      UserModalService.report().close()
    }
  }
})
</script>
