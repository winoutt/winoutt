<template lang="pug">
  .profile-info.mb-4
    .card(:enable-body="canShowAbout")
      .card-content
        .border-bottom
          .row.no-gutters
            .col-lg-144.col-xl-72.text-center.avatar-counter.border-right
              AvatarLarge.avatar.mb-3.cursor-pointer(:user="profile" @click.native="showLightbox()")
              h6.mb-0.px-3
                FullName.name {{ profile.full_name }}
              .title.px-3
                JobTitle.text-secondary {{ profile.title }}
              .row.count
                .col
                  .count-wrapper.d-flex.justify-content-between.border-top(
                    @click="openConnectionsModal()"
                    :class="{ 'cursor-pointer' : profile.connections_count }"
                  )
                    p.mb-0 Connections
                    h6.font-weight-bold.mb-0(v-if="profile.connections_count") {{ Humanize.count(profile.connections_count) }}
              .row.count
                .col
                  .count-wrapper.posts-count.d-flex.justify-content-between.border-top.border-bottom
                    p.mb-0 Posts
                    h6.font-weight-bold.mb-0(v-if="profile.posts_count") {{ Humanize.count(profile.posts_count) }}
            .col-lg-144.col-xl-72
              .contact-wrapper.d-flex.flex-column.justify-content-between.h-100
                .contact
                  .info.d-flex.justify-content-between.mb-3
                    h6.font-weight-bold.mb-0 Contact info
                    Dropdown(v-if="!profile.is_user")
                      .dropdown-item.cursor-pointer(@click="report()") Report this profile
                  .location.d-flex(v-if="canShowLocation")
                    Icon.icon-location(name="location")
                    .location-name {{ profile.city + ', ' + profile.country }}
                  .profile-link.d-flex
                    Icon.icon-logo(name="logo")
                    .text-truncate
                      a.profile Joined {{ joinedAt }}
                  .websites.d-flex(v-if="canShowWebsites")
                    Icon.icon-globe(name="globe")
                    .text-truncate
                      .text-truncate(v-if="profile.website.company")
                        a.company.mr-2(:href="profile.website.company" target="_blank") {{ Humanize.url(profile.website.company) }}
                      .text-truncate(v-if="profile.website.personal")
                        a.personal(:href="profile.website.personal" target="_blank") {{ Humanize.url(profile.website.personal) }}
                .actions-wrapper.mt-3.mt-xl-0(v-if="!profile.is_user")
                  .actions.d-flex.align-items-center
                    UserActions(:user="profile" :disconnectButton="true")
                  UserMutualConnections(:user="profile")
      .card-body.p-3
        .row.user-about(v-if="canShowAbout")
          .col
            .d-flex.justify-content-between
              h6.about.font-weight-bold About
            ReadMore.read-more(:text="profile.bio" :max-chars="270")
    UserDisconnectConfirmModal
    UserReportModal(:profile="profile")
    Lightbox(:media="profile.avatar_original" :canShow="canShowLightBox" @hide="canShowLightBox = false")
</template>

<script lang="ts">
import Vue from 'vue'
import UserModalService from '../../../services/ModalServices/UserModalService'
import UserState from '../../../State/UserState'
import AuthToken from '../../../services/AuthToken'
import IntendedRedirect from '../../../services/IntendedRedirect'

import AvatarLarge from '../../avatar/AvatarLarge.vue'
import UserActions from '../../user/UserActions.vue'
import Icon from '../../Icon.vue'
import ReadMore from '../../ReadMore.vue'
import UserDisconnectConfirmModal from '../../user/UserDisconnectConfirmModal.vue'
import UserReportModal from '../../user/UserReportModal.vue'
import UserMutualConnections from '../../user/UserMutualConnections.vue'
import Lightbox from '../../Lightbox.vue'
import FullName from '../../FullName.vue'
import JobTitle from '../../JobTitle.vue'
import Dropdown from '../../Dropdown.vue'
import ConnectionRequest from '../../../Request/ConnectionRequest'

export default Vue.extend({
  components: {
    AvatarLarge,
    UserActions,
    Icon,
    ReadMore,
    UserDisconnectConfirmModal,
    UserReportModal,
    UserMutualConnections,
    Lightbox,
    FullName,
    JobTitle,
    Dropdown
  },

  data () {
    return {
      canShowLightBox: false
    }
  },

  computed: {
    profile () {
      return UserState.collectProfile()
    },
    profileUrl () {
      const appUrl = window.location.origin
      return `${appUrl}/user/${this.profile.username}`
    },
    canShowAbout () {
      return this.profile.bio
    },
    canShowWebsites () {
      const { website: { company, personal } } = this.profile
      return company || personal
    },
    canShowLocation () {
      const { city, country } = this.profile
      return city && country
    },
    joinedAt () {
      return this.Util.date.monthAndYear(this.profile.created_at)
    }
  },

  methods: {
    report () {
      if (!AuthToken.has()) return IntendedRedirect.redirect(this.$route.path)
      UserModalService.report().open()
    },
    showLightbox () {
      this.canShowLightBox = !this.canShowLightBox
    },
    openConnectionsModal () {
      if (!AuthToken.has()) return IntendedRedirect.redirect(this.$route.path)
      if (!this.profile.connections_count) return
      ConnectionRequest.list(this.profile)
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../../sass/variables'

.title
  margin-bottom: 30px
.location
  .icon-location
    width: 17px
    height: 20px
.websites
  .icon-globe
    width: 18px
    height: 18px
.profile-link
  .icon-logo
    width: 18px
    height: 18px
.location,
.profile-link
  margin-bottom: 12px
.icon-location,
.icon-globe,
.icon-logo
    margin-right: 12px
.about
  font-size: 1rem
.name
  font-size: 1.15em
.vertical-divider
  width: 1px
  background: $border-color
.avatar
  margin-top: 32px
  display: inline-block
.contact-wrapper
  padding: 0 19px
  padding-top: 27px
  padding-bottom: 11px
  .contact
    h6
      font-size: 1rem
    .icon
      margin-top: 2px
.actions
  margin-bottom: 10px
.count-wrapper
  padding: 8px 16px

@media (max-width: 1199px)
  .avatar-counter
    border-right: none !important

@media (min-width: 1200px)
  .count-wrapper.posts-count
    border-bottom: none !important
</style>
