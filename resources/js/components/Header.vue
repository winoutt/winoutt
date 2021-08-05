<template lang="pug">
  #header.header.row.pt-3.sticky-top
    .col-md-72.offset-md-2.col-lg-89.offset-lg-1.col-xl-94.offset-xl-4
      .row.mobile-logo.align-items-center.pb-3.pb-sm-0.border-bottom.border-sm-0
        .col-60.d-block.d-sm-none
          LogoSmall(:full-width="true")
        .col-84.col-md-144.col-lg-76.offset-lg-34.col-xl-56.offset-xl-44.pr-0
          SearchAll
    .col-md-70.col-lg-54.col-xl-43.offset-xl-3.pr-0
      .row.header-links.justify-content-between.align-items-center.mt-3.mt-sm-0
        .col-48.d-block.d-sm-none
          Icon.icon-menu(name="menu" @click.native="toggleMobileMenu()")
        .col-48.col-md-46.col-xl-40.offset-md-52.offset-xl-64
          p.notes.mb-0.cursor-pointer.text-right.d-inline-flex(
            :class="activeNotes ? 'acitve-notes' : ''"
            @click="replaceActiveNotes()"
          )
            Icon.icon-note.mr-2(name="note")
            | Notes
        .col-48.col-md-46.col-xl-40
          .dropdown.d-flex.d-block.justify-content-center
            #dropdownMenu.dropdown-toggle.d-flex.align-items-center.cursor-pointer(
              data-toggle='dropdown'
              aria-haspopup='true'
              aria-expanded='false'
            )
              AvatarSmall.mr-2(:user="user")
            .dropdown-menu.dropdown-menu-right.shadow(aria-labelledby='dropdownMenu')
              router-link.dropdown-item(
                :to="{ name: 'Profile', params: { username: user.username } }"
              ) Profile
              a.dropdown-item(href='#' @click.prevent="signOut()") Sign out
</template>

<script lang="ts">
import Vue from 'vue'

import NoteState from '../State/NoteState'
import AuthRequest from '../Request/AuthRequest'
import UserState from '../State/UserState'
import NoteRequest from '../Request/NoteRequest'
import Request from '../Request/Request'
import MobileMenu from '../services/MobileMenu'
import MobileMenuScroll from '../Scroll/MobileMenuScroll'

import SearchAll from './SearchAll.vue'
import AvatarSmall from './avatar/AvatarSmall.vue'
import Icon from './Icon.vue'
import LogoSmall from './logo/LogoSmall.vue'

export default Vue.extend({
  components: {
    SearchAll,
    AvatarSmall,
    Icon,
    LogoSmall
  },

  computed: {
    user () {
      return UserState.collectUser()
    },
    activeNotes () {
      return NoteState.collectActive()
    }
  },

  methods: {
    signOut () {
      AuthRequest.logout()
    },
    async replaceActiveNotes () {
      if (!this.activeNotes) {
        const requests = [
          NoteRequest.list(),
          NoteRequest.archived()
        ]
        const { isFailed } = await Request.bulk(requests)
        if (isFailed) return
      } else NoteRequest.deleteBlanks()
      NoteState.replaceActive()
    },
    toggleMobileMenu () {
      MobileMenuScroll.toTop()
      MobileMenu.toggle()
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.header
  background: $grey-light
  z-index: 1021
  padding-bottom: 1.7rem

  .icon-menu
    width: 17px
    height: 17px

.dropdown
  z-index: 1021
  .dropdown-menu
    top: 6px !important

.notes
  transition: all 0.4s
  &.acitve-notes
    color: $primary !important
    .icon-note
      fill: $primary !important
  .icon-note
    width: 17px
    height: 17px

@media (max-width: 768px)
  .header
    z-index: 1020 !important

@media (min-width: 576px)
  .mobile-logo
    border-bottom: none !important
</style>
