<template lang="pug">
  .aside(:class="topMargin")
    template(v-if="isTeamPage")
      TeamInfo(:class="mobileHideClass")
      TeamTopContributors(:class="mobileHideClass")
    template(v-else)
      AsidePeople(:class="mobileHideClass")
      AsideTrendingTags(:class="mobileHideClass")
    AsideFooter
</template>

<script lang="ts">
import Vue from 'vue'
import { includes } from 'lodash'

import AsidePeople from './AsidePeople.vue'
import AsideTrendingTags from './AsideTrendingTags.vue'
import AsideFooter from './AsideFooter.vue'
import TeamInfo from '../views/team/TeamInfo.vue'
import TeamTopContributors from '../views/team/TeamTopContributors.vue'

export default Vue.extend({
  components: {
    AsidePeople,
    AsideTrendingTags,
    AsideFooter,
    TeamInfo,
    TeamTopContributors
  },

  computed: {
    isTeamPage () {
      return this.$route.name === 'Team'
    },
    topMargin () {
      const isProfilePage = this.$route.name === 'Profile'
      const isPostPage = this.$route.name === 'Post'
      const canMargin = isProfilePage || this.isTeamPage || isPostPage
      return { 'top-margin': canMargin }
    },
    mobileHideClass () {
      const paginatables = [
        'Notifications',
        'Team',
        'Profile',
        'Favourites',
        'HashtagResult'
      ]
      const isMobileHide = includes(paginatables, this.$route.name)
      return { 'd-none d-sm-block': isMobileHide }
    }
  }
})
</script>

<style lang="sass" scoped>
.aside
  margin-top: 50px
  &.top-margin
    margin-top: 20px

@media (max-width: 576px)
  .aside
    margin-top: 0
</style>
