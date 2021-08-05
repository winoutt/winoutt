<template lang="pug">
  .post.position-relative(v-if="!Util.isEmpty(post)")
    router-link.team.position-absolute.rounded-bottom.no-hover(
      v-if="canShowTeam"
      :to="{ name: 'Team', params: { slug: post.team.slug } }"
    ) {{ post.team.name }}
    .post-wrapper.border.bg-white
      PostHeader(:post="post")
      Content.mb-3(:post="post" type="large")
      PostFooter(:post="post")
</template>

<script lang="ts">
import Vue from 'vue'
import PostHeader from './PostHeader.vue'
import Content from '../Content.vue'
import PostFooter from './PostFooter.vue'

export default Vue.extend({
  props: ['post'],
  components: {
    PostHeader,
    Content,
    PostFooter
  },

  computed: {
    canShowTeam () {
      return this.$route.name !== 'Team'
    }
  }
})
</script>

<style lang="sass" scoped>
.post
  .team
    top: 0
    right: 0
    background: #e9ecee
    border-bottom-right-radius: 0 !important
    padding: 6px 20px
  .post-wrapper
    border-radius: 3px
    padding: 30px 25px
    margin-bottom: 0.725rem

@media (max-width: 576px)
  .post:last-child .post-wrapper
    margin-bottom: 0 !important
</style>
