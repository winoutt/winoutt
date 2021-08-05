<template lang="pug">
  .home-top-teams.mb-2
    HeadingSmall.my-3 Top teams
    .row.top-teams
      .col-md(v-for="team in top")
        HomeTeam(:team="team")
</template>

<script lang="ts">
import Vue from 'vue'
import TeamState from '../../../State/TeamState'

import HeadingSmall from '../../heading/HeadingSmall.vue'
import HomeTeam from './HomeTeam.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    HomeTeam
  },

  computed: {
    top () {
      return TeamState.collectTop()
    }
  }
})
</script>
