<template lang="pug">
  .notes-list
    .note.border.rounded.mb-3.position-relative(
      v-for="note in notes" :key="note.id"
      :data-value="activeNote.content"
      v-max-character="1000"
      :class="`note-${note.id}`"
    )
      .note-content.d-flex.justify-content-between.mb-1
        .editor.pre.border-0.p-0.w-100.mb-0(
          placeholder="Write your note..."
          contenteditable="true"
          :id="`note-content-${note.id}`"
          @input="updateInput($event, note)"
          v-once v-if="canShowTextarea(note)"
          dir="auto"
          @focus="toggleDone(note)"
          @blur="done(note)"
        ) {{ note.content }}
        ReadMore(:text="note.content" :maxChars="100" v-else)
        .ml-auto
          Dropdown.ml-2(id="noteActions" v-if="note.id !== activeNote.id")
            .dropdown-item.cursor-pointer(@click="edit(note)") Edit
            .dropdown-item.cursor-pointer(@click.stop="archive(note)" v-if="note.content") Archive
      h6.done.d-block.ml-auto.cursor-pointer.mb-0(:id="`done-${note.id}`" @click="done(note)") Done
</template>

<script lang="ts">
import Vue from 'vue'
import $ from 'jquery'
import { isEmpty } from 'lodash'

import NoteState from '../../State/NoteState'
import NoteRequest from '../../Request/NoteRequest'
import maxCharacter from '../../directives/maxCharacter'
import Dropdown from '../Dropdown.vue'
import ReadMore from '../ReadMore.vue'
import Validate from '../../services/Validate'

export default Vue.extend({
  components: {
    Dropdown,
    ReadMore
  },

  directives: {
    maxCharacter
  },

  computed: {
    notes () {
      return NoteState.collectNotes()
    },
    activeNote: {
      get () {
        return NoteState.collectActiveNote()
      },
      set (note) {
        NoteState.replaceActiveNote(note)
      }
    }
  },

  methods: {
    edit (note) {
      this.activeNote = note
      this.$nextTick(() => {
        $(`#note-content-${note.id}`).focus()
      })
    },
    canShowTextarea (note) {
      return this.activeNote.id === note.id
    },
    showDone (noteId) {
      const doneDom = document.getElementById(`done-${noteId}`)
      doneDom.style.visibility = 'visible'
    },
    toggleDone (note) {
      if (note.content) return this.showDone(note.id)
      else return this.hideDone(note.id)
    },
    updateInput (event, note) {
      const content = event.target.innerText
      note.content = content
      this.toggleDone(note)
    },
    hideDone (noteId) {
      const doneDom = document.getElementById(`done-${noteId}`)
      doneDom.style.visibility = 'hidden'
    },
    remove (id) {
      NoteRequest.delete(id)
    },
    async done (note) {
      const isMaxCharacter = Validate.helperText().existsOn(`.note-${note.id}`)
      if (isMaxCharacter) return
      if (!note.content) return this.remove(note.id)
      const response = await NoteRequest.edit(note.id, { content: note.content })
      if (isEmpty(response)) return
      this.hideDone(note.id)
      this.activeNote = {}
    },
    archive (note) {
      NoteRequest.archive(note)
    }
  }
})
</script>

<style lang="sass" scoped>
.notes-list
  .note
    padding: 15px 17px
    .note-content
      word-break: break-word
      .editor
        outline: none
        cursor: text
      [contenteditable=true]:empty::before
        content: attr(placeholder)
      #noteActions
        margin-top: 3px
    .done
      width: fit-content
      visibility: hidden
</style>

<style lang="sass">
.notes-list
  .form-helper-text
    margin-top: -5px
</style>
