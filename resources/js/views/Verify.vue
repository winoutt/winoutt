<script lang="ts">
import Vue from 'vue'
import VerificationRequest from '../Request/VerificationRequest'

export default Vue.extend({
  async beforeRouteEnter (to, from, next) {
    const payload = { token: to.params.token }
    await VerificationRequest.verify(payload)
    next({ name: 'SignIn' })
  }
})
</script>
