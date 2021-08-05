<template lang="pug">
.row.people
  .col
    HeadingSmall.my-3 People you may know
    .row(v-if="!Util.isEmpty(userGroup)")
      template(v-for="(users, index) in userGroup")
        .col-md-72.col-lg-48.col-xl-36( v-for="user in users" :key="user.id")
          UserVertical(:user="user")
    NoResults(v-else text="The results are not available yet.").mt-3
</template>

<script lang="ts">
import Vue from 'vue'
import { chunk } from 'lodash'
import PeopleRequest from '../Request/PeopleRequest'
import UserState from '../State/UserState'
import Request from '../Request/Request'

import HeadingSmall from '../components/heading/HeadingSmall.vue'
import UserVertical from '../components/user/UserVertical.vue'
import NoResults from '../components/NoResults.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    UserVertical,
    NoResults
  },

  async beforeRouteEnter (to, from, next) {
    const requests = [PeopleRequest.paginate()]
    const { isFailed } = await Request.bulk(requests)
    if (!isFailed) next()
  },

  computed: {
    userGroup () {
      const users = UserState.collectUsers()
      return chunk(users, 3)
    }
  }
})
</script>
