<template lang="pug">
.post-new-wrapper.position-absolute(v-if="hasNew" @click="scrollToNew()")
  .post-new.position-fixed.d-flex.align-items-center.rounded-pill.cursor-pointer.py-2.px-4
    Icon.icon-up.mr-2(name="up")
    span New posts
</template>

<script lang="ts">
import Vue from 'vue'
import PostScroll from '../../Scroll/PostScroll'
import PostState from '../../State/PostState'

import Icon from '../Icon'

export default Vue.extend({
  components: {
    Icon
  },

  computed: {
    hasNew () {
      return PostState.collectHasNew()
    }
  },

  methods: {
    scrollToNew () {
      PostScroll.team.newPost()
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables'

.post-new-wrapper
  top: 0px
  left: 50%
  .post-new
    background: $primary
    z-index: 2
    white-space: nowrap
    transform: translate(-50%, -50%)
    color: #fff
    .icon-up
      width: 13px
      height: 15px
      fill: #fff

@media (max-width: 576px)
  .post-new
    top: 215px
</style>
