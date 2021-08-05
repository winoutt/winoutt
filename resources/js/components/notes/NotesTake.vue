<template lang="pug">
  .notes-take.d-flex.justify-content-between.align-items-center.mb-3
    .d-flex.align-items-center.cursor-pointer(@click="addNote()")
      Icon.icon-add.mr-2(name="add")
      h6.mb-0 Take a note
    Close(@click.native="close()")
</template>

<script lang="ts">
import Vue from 'vue'
import $ from 'jquery'
import { find, isEmpty } from 'lodash'
import NoteRequest from '../../Request/NoteRequest'
import NoteState from '../../State/NoteState'

import Icon from '../Icon.vue'
import Close from '../Close.vue'

export default Vue.extend({
  components: {
    Icon,
    Close
  },

  computed: {
    hasBlankNote () {
      return NoteState.collectHasBlankNote()
    }
  },

  methods: {
    focusBlankNote () {
      const notes = NoteState.collectNotes()
      const note = find(notes, note => isEmpty(note.content))
      NoteState.replaceActiveNote(note)
      setTimeout(() => {
        $(`#note-content-${note.id}`).focus()
      }, 0)
    },
    addNote () {
      if (this.hasBlankNote) return this.focusBlankNote()
      const note = {
        content: ''
      }
      NoteRequest.create(note)
    },
    close () {
      NoteRequest.deleteBlanks()
      NoteState.replaceActive()
    }
  }
})
</script>

<style lang="sass" scoped>
.notes-take
  .icon-add
    width: 18px
    height: 18px
  h6
    font-size: 1.125rem
</style>
