<template lang="pug">
  #notes.h-100.notes.sticky-top.bg-white.border-top.border-left(:class="activeNotes ? 'active' : ''")
    .notes-wrapper.pt-3
      NotesTake
      NotesMenu
      .list.scroll.pr-1
        NotesList(v-if="tab === 'notes'")
        NotesArchivedList(v-else)
</template>

<script lang="ts">
import Vue from 'vue'
import NoteState from '../../State/NoteState'

import NotesTake from './NotesTake.vue'
import NotesMenu from './NotesMenu.vue'
import NotesList from './NotesList.vue'
import NotesArchivedList from './NotesArchivedList.vue'

export default Vue.extend({
  components: {
    NotesTake,
    NotesMenu,
    NotesList,
    NotesArchivedList
  },

  computed: {
    activeNotes () {
      return NoteState.collectActive()
    },
    tab () {
      return NoteState.collectTab()
    }
  }
})
</script>

<style lang="sass" scoped>
@import '../../../sass/variables.scss'

.notes
  position: fixed
  z-index: 1020
  top: 87px
  right: 0
  width: 0
  transition: 0.2s
  border-top-left-radius: 3px
  .notes-wrapper
    padding-right: 15px
    .list
      max-height: calc(100vh - 175px)
  &.active
    width: 24%
    padding: 0 16px

@media (max-width: 768px)
  .notes
    top: 0 !important
    .notes-wrapper .list
      max-height: calc(100vh - 130px)
  .active
    width: 100% !important
</style>
