<template lang="pug">
  .poll(v-if="post.poll.question")
    PollVote(v-if="canShowPollVote" :post="post")
    PollResult(v-else :post="post")
</template>

<script lang="ts">
import Vue from 'vue'
import moment from 'moment'

import PollVote from './PollVote.vue'
import PollResult from './PollResult.vue'

export default Vue.extend({
  props: ['post'],
  components: {
    PollVote,
    PollResult
  },

  computed: {
    canShowPollVote () {
      if (this.post.is_user) return false
      const isValid = moment().isBefore(this.post.poll.end_at)
      return !this.post.poll.is_voted && isValid
    }
  }
})
</script>
