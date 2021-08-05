<template lang="pug">
  .poll-result.w-100
    .question.text-left.mb-3 {{ post.poll.question }}
    .choices
      .choice.text-left.mb-2.position-relative.d-flex.justify-content-between.align-items-center(
        v-for="choice in post.poll.choices"
      )
        .background.position-absolute.rounded(
          :style="`width: ${votePercentage(choice)}%;`"
        )
        .details.px-2.py-1.d-flex.align-items-center
          .name.mr-2 {{ choice.value }}
          Icon.icon-check(name="accept" v-if="choice.is_voted")
        .percentage.px-2.py-1 {{ votePercentage(choice) }}%
    PollDetails(:post="post")
</template>

<script lang="ts">
import Vue from 'vue'
import { round } from 'lodash'

import Icon from '../Icon.vue'
import PollDetails from './PollDetails.vue'

export default Vue.extend({
  props: ['post'],
  components: {
    Icon,
    PollDetails
  },
  methods: {
    votePercentage (choice) {
      if (!this.post.poll_votes_count) return 0 // Percentage NaN fix
      var percentage = (choice.votes_count / this.post.poll_votes_count) * 100
      percentage = round(percentage)
      return percentage
    }
  }
})
</script>

<style lang="sass" scoped>
.choice
  .background
    background: #ddd
    min-width: 0.8%
    height: 100%
    top: 0
  .icon-check
    width: 15px
    height: 15px
  .details, .percentage
    z-index: 1
</style>
