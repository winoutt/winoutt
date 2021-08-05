<template lang="pug">
  .team-info
    AsideCard
      template(v-slot:card-content)
        img.rounded-top(:src="team.photo")
      template(v-slot:card-body)
        AsideHeading.mb-3(:heading="team.name")
        p.mb-2
          span.font-weight-bold Shared goal or purpose of the team:
          span.goal  {{ team.goal }}
</template>

<script lang="ts">
import Vue from 'vue'
import TeamState from '../../../State/TeamState'

import AsideCard from '../../aside/AsideCard.vue'
import AsideHeading from '../../aside/AsideHeading.vue'

export default Vue.extend({
  components: {
    AsideCard,
    AsideHeading
  },

  computed: {
    team () {
      return TeamState.collectTeam()
    }
  }
})
</script>

<style lang="sass" scoped>
.team-info
  margin-bottom: 0.725rem
  img
    max-height: 200px
    object-fit: contain
</style>
