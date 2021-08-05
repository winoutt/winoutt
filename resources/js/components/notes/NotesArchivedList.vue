<template lang="pug">
  .notes-archived-list
    .note.border.rounded.mb-3(v-for="note in notes" :key="note.id")
      .note-content.d-flex.justify-content-between
        ReadMore.mr-2(:text="note.content" :maxChars="100")
        Dropdown.ml-auto(id="noteArchivedActions")
          .dropdown-item.cursor-pointer(@click="unarchive(note)") Unarchive
</template>

<script lang="ts">
import Vue from 'vue'
import NoteState from '../../State/NoteState'
import NoteRequest from '../../Request/NoteRequest'

import Dropdown from '../Dropdown.vue'
import ReadMore from '../ReadMore.vue'

export default Vue.extend({
  components: {
    Dropdown,
    ReadMore
  },

  computed: {
    notes () {
      return NoteState.collectArchived()
    }
  },

  methods: {
    unarchive (note) {
      NoteRequest.unarchive(note)
    }
  }
})
</script>

<style lang="sass" scoped>
.notes-archived-list
  .note
    padding: 15px 17px
    .note-content
      word-break: break-word
      #noteArchivedActions
        margin-top: 3px
</style>
