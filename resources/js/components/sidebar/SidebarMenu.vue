<template lang="pug">
  .menu
    ul.mb-0.pl-0
      SidebarMenuItem(name="Home" icon="home")
      SidebarMenuItem(
        name="Notifications"
        icon="bell"
        :count="notificationsUnreads"
      )
      SidebarMenuItem(
        name="Messages"
        icon="mail"
        :count="messagesUnreads"
      )
      SidebarMenuItem(name="Favorites" icon="bookmark" router="Favourites")
      SidebarMenuItem(name="Top posts" icon="trophy" router="TopPosts")
      SidebarMenuItem(name="People" icon="people")
      SidebarMenuItem(name="About" icon="help" router="AboutUs" target="_blank")
      SidebarMenuItem(name="Settings" icon="settings")
</template>

<script lang="ts">
import Vue from 'vue'
import SidebarMenuItem from './SidebarMenuItem.vue'
import MessageState from '../../State/MessageState'
import NotificationState from '../../State/NotificationState'

export default Vue.extend({
  components: {
    SidebarMenuItem
  },

  computed: {
    messagesUnreads () {
      return MessageState.collectUnreadsCount()
    },
    notificationsUnreads () {
      return NotificationState.collectUnreadsCount()
    }
  }
})
</script>

<style lang="sass" scoped>
.menu
  ul
    list-style: none
</style>
