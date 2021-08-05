<template lang="pug">
  .row.home-page
    .col
      HomeTopTeams
      HomeAllTeams
</template>

<script lang="ts">
import Vue from 'vue'
import TeamRequest from '../Request/TeamRequest'
import PeopleRequest from '../Request/PeopleRequest'
import HashtagRequest from '../Request/HashtagRequest'
import Request from '../Request/Request'

import HomeTopTeams from '../components/views/home/HomeTopTeams.vue'
import HomeAllTeams from '../components/views/home/HomeAllTeams.vue'

export default Vue.extend({
  components: {
    HomeTopTeams,
    HomeAllTeams
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [
      TeamRequest.top(),
      TeamRequest.list(),
      PeopleRequest.mayknow(),
      HashtagRequest.trending()
    ]
    const { isFailed } = await Request.bulk(requests)
    if (!isFailed) next()
  }
})
</script>
