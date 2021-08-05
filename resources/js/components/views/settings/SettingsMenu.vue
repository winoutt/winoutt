<template lang="pug">
  .card.settings-menu.pb-3
    .card-body.pl-3.pr-2
      ul.p-0.mb-0
        li.d-flex.align-items-center.cursor-pointer(@click="setActive('profile')" :class="active === 'profile' ? 'active' : ''")
          Icon.mr-3(:name="active === 'profile' ? 'user-active' : 'user'")
          p.mb-0 Account info
        li.d-flex.align-items-center.cursor-pointer(@click="setActive('changePassword')" :class="active === 'changePassword' ? 'active' : ''")
          Icon.mr-3(:name="active === 'changePassword' ? 'key-active' : 'key'")
          p.mb-0 Change password
        li.d-flex.align-items-center.cursor-pointer(@click="setActive('notifications')" :class="active === 'notifications' ? 'active' : ''")
          Icon.mr-3(:name="active === 'notifications' ? 'bell-active' : 'bell'")
          p.mb-0 Notifications
        li.d-flex.align-items-center.cursor-pointer(@click="setActive('appearance')" :class="active === 'appearance' ? 'active' : ''")
          Icon.mr-3(:name="active === 'appearance' ? 'bulb-active' : 'bulb'")
          p.mb-0 Appearance
        li.d-flex.align-items-center.cursor-pointer(@click="setActive('deleteAccount')" :class="active === 'deleteAccount' ? 'active' : ''")
          Icon.mr-3(:name="active === 'deleteAccount' ? 'remove-active' : 'remove'")
          p.mb-0 Delete account
</template>

<script lang="ts">
import Vue from 'vue'
import SettingsState from '../../../State/SettingsState'

import Icon from '../../Icon.vue'

export default Vue.extend({
  components: {
    Icon
  },

  computed: {
    active () {
      return SettingsState.collectActive()
    }
  },

  methods: {
    setActive (active) {
      SettingsState.replaceActive(active)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../../sass/variables'

.settings-menu
  height: calc(100% - 45px)
  ul
    list-style: none
    li
      padding: 8px 5px
      .icon
        width: 19px
        height: 18px
      .icon-toggle
        width: 21px
        height: 12px
      p
        font-size: 0.9375rem
      &.active
        p
          font-weight: 700
          color: $primary
        .icon
          fill: $primary
</style>
