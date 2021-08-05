<template lang="pug">
  .poll-vote.text-left
    .poll-question.mb-3 {{ post.poll.question }}
    .poll-choices.d-flex.flex-column
      ButtonOutlineSmall.rounded-pill.mb-2(
        v-for="choice in post.poll.choices"
        :text="choice.value"
        :key="choice.id"
        @click.native="vote(choice)"
      )
    PollDetails(:post="post")
</template>

<script lang="ts">
import Vue from 'vue'
import PollVoteRequest from '../../Request/PollVoteRequest'
import Alert from '../../services/Alert'

import ButtonOutlineSmall from '../button/ButtonOutlineSmall.vue'
import PollDetails from './PollDetails.vue'
import AuthToken from '../../services/AuthToken'
import IntendedRedirect from '../../services/IntendedRedirect'

export default Vue.extend({
  props: ['post'],
  components: {
    ButtonOutlineSmall,
    PollDetails
  },

  methods: {
    vote (choice) {
      if (!AuthToken.has()) return IntendedRedirect.post(this.post.id)
      if (!choice.id) return // Preview in create new post
      const message = 'You can\'t vote your own poll'
      if (this.post.is_user) return Alert.error(message)
      const payload = { poll_id: this.post.poll.id, choice_id: choice.id }
      PollVoteRequest.create(payload)
    }
  }
})
</script>
