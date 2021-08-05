<template lang="pug">
  .upvote.d-flex.align-items-center(
    :class="[comment.is_voted ? 'active' : '', comment.is_user ? '' : 'cursor-pointer']"
    @click="vote()"
  )
    Icon.icon-up.mr-1(name="up")
    .content.d-flex
      .text Upvote
      .count(v-if="hasCount") {{ comment.votes_count }}
</template>

<script lang="ts">
import Vue from 'vue'

import CommentVoteRequest from '../../Request/CommentVoteRequest'

import Icon from '../Icon.vue'

export default Vue.extend({
  props: ['comment'],

  components: {
    Icon
  },

  computed: {
    hasCount () {
      return this.comment.votes_count
    }
  },

  methods: {
    vote () {
      if (this.comment.is_user) return
      if (this.comment.is_voted) CommentVoteRequest.delete(this.comment)
      else CommentVoteRequest.create(this.comment)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.upvote
  width: fit-content
  background: #f5f5f5
  padding: 6px 13px
  border-radius: 3px
  margin: 15px 0
  .icon-up
    width: 11px
    height: 13px
  .content
    font-size: 0.813rem
    .text
      margin-left: 2px
    .count
      margin-left: 6px
  &.active
    font-weight: 500
    .icon-up
      fill: $primary
    .content
      color: $primary
</style>
