<template lang="pug">
  .home-all-teams.mb-0.mb-sm-4
    HeadingSmall.heading.mb-3 All teams
    .row.all-teams(v-for="teams in teamRows")
      .col-md(v-for="team in teams")
        HomeTeam(:team="team")
</template>

<script lang="ts">
import Vue from 'vue'
import { chunk } from 'lodash'
import TeamState from '../../../State/TeamState'

import HeadingSmall from '../../heading/HeadingSmall.vue'
import HomeTeam from './HomeTeam.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    HomeTeam
  },

  computed: {
    teamRows () {
      return chunk(TeamState.collectTeams(), 3)
    }
  }
})
</script>

<style lang="sass" scoped>
.heading
  margin-top: 24px !important
</style>
