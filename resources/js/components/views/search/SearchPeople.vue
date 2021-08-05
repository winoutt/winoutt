<template lang="pug">
  .search-people
    template(v-if="people.length")
      h6.font-weight-bold.mb-2 People
      .row
        .col-md-144.mb-2(v-for="user in people")
          User.search-user.bg-white.border(:user="user" :swapRequestButtons="true")
            template(v-slot:UserMutualConnections)
              UserMutualConnections(:user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import User from '../../user/User.vue'
import UserMutualConnections from '../../user/UserMutualConnections.vue'

export default Vue.extend({
  props: ['people'],
  components: {
    User,
    UserMutualConnections
  }
})
</script>

<style lang="sass" scoped>
h6
  font-size: 1.125rem
.search-user
  padding-bottom: 0 !important
  border-radius: 8px
  padding: 0 12px
</style>
