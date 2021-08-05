<template lang="pug">
  .user-vertical.pb-3
    .card
      .card-body.d-flex.flex-column.align-items-center
        router-link.no-hover.text-center(:to="{ name: 'Profile', params: { username: user.username } }")
          AvatarMedium.pt-2.mb-3(
            :user="user"
            :size="70"
          )
          .w-100.text-center
            FullName.name.font-weight-bold {{ user.full_name }}
          JobTitle.title.text-secondary {{ user.title }}
        UserMutualConnections.mutuals(:user="user" :fontSize="0.813")
        UserActions.mb-2(:user="user")
</template>

<script lang="ts">
import Vue from 'vue'
import AvatarMedium from '../avatar/AvatarMedium.vue'
import UserMutualConnections from './UserMutualConnections.vue'
import UserActions from './UserActions.vue'
import FullName from '../FullName.vue'
import JobTitle from '../JobTitle.vue'

export default Vue.extend({
  props: ['user'],
  components: {
    AvatarMedium,
    UserMutualConnections,
    UserActions,
    FullName,
    JobTitle
  }
})
</script>

<style lang="sass" scoped>
.card
  min-height: 274px
.name
  font-size: 1rem
  margin-bottom: 1px
.title
  font-size: 0.875rem
  margin-bottom: 1px
.mutuals
  margin-bottom: 15px
</style>
