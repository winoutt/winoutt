<template lang="pug">
  .team-top-contributors.pb-3
    AsideCard(v-if="!Util.isEmpty(contributors)")
      template(v-slot:card-body)
        AsideHeading(heading="Top teammates")
        .contributors.mb-2
          router-link.contributor.d-flex.align-items-center.py-2.px-2.no-hover(
            v-for="(user, index) in contributors"
            :key="user.id"
            :to="{ name: 'Profile', params: { username: user.username } }"
          )
            p.count.font-weight-bold.mb-0.mr-3 {{ index + 1 }}.
            AvatarSmall.mr-2(:user="user" :size="47")
            .user-info.d-flex.flex-column.justify-content-center.text-truncate
              FullName.name.font-weight-bold {{ user.full_name }}
              JobTitle.title.text-secondary.pb-1 {{ user.title }}
</template>

<script lang="ts">
import Vue from 'vue'
import UserState from '../../../State/UserState'

import AsideCard from '../../aside/AsideCard.vue'
import AsideHeading from '../../aside/AsideHeading.vue'
import AvatarSmall from '../../avatar/AvatarSmall.vue'
import FullName from '../../FullName.vue'
import JobTitle from '../../JobTitle.vue'

export default Vue.extend({
  components: {
    AsideCard,
    AsideHeading,
    AvatarSmall,
    FullName,
    JobTitle
  },

  computed: {
    contributors () {
      return UserState.collectUsers()
    }
  }
})
</script>

<style lang="sass" scoped>
.count
  font-size: 0.85rem
.contributor
  margin-bottom: 8px
  &:last-child
    margin-bottom: 0 !important
  .name
    margin-bottom: -1px
  .title
    font-size: 0.813rem
</style>
