<template lang="pug">
  small.poll-details.d-flex
    .poll-votes-count.mr-2(v-if="post.is_user && post.poll_votes_count") {{ votesCount }}
    .poll-duration {{ duration }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['post'],

  computed: {
    duration () {
      const isEnded = this.Util.date.isEnded(this.post.poll.end_at)
      const fromNow = this.Humanize.fromNow(this.post.poll.end_at)
      return `${isEnded ? 'Ended' : 'Ends'} ${fromNow}`
    },
    votesCount () {
      const count = this.post.poll_votes_count
      return `${count} ${count <= 1 ? 'vote' : 'votes'}`
    }
  }
})
</script>
