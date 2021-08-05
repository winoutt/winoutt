<template lang="pug">
  AsideCard.aside-people(v-if="!Util.isEmpty(people) && hasAuth")
    template(v-slot:card-body)
      AsideHeading(heading="People you may know")
      User.aside-user(
        v-for="user in people" :key="user.id"
        :user="user"
        :userActions="false"
        :avatarSize="47"
        :titlePaddingBottom="4"
      )
        template(v-slot:UserMutualConnections)
          UserMutualConnections(:user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../State/UserState'
import AuthToken from '../../services/AuthToken'

import AsideCard from './AsideCard.vue'
import AsideHeading from './AsideHeading.vue'
import User from '../user/User.vue'
import UserMutualConnections from '../user/UserMutualConnections.vue'

export default Vue.extend({
  components: {
    AsideCard,
    AsideHeading,
    User,
    UserMutualConnections
  },

  computed: {
    people () {
      return UserState.collectUsers()
    },
    hasAuth () {
      return AuthToken.has()
    }
  }
})
</script>

<style lang="sass" scoped>
.aside-people
  margin-bottom: 0.725rem
  .aside-user:last-child
    padding-bottom: 0 !important
</style>
