<template lang="pug">
  CustomMenu.mb-4(:titles="['Notes', 'Archived']" :values="['notes', 'archived']" v-model="tab")
</template>

<script lang="ts">
import Vue from 'vue'
import NoteState from '../../State/NoteState'

import CustomMenu from '../CustomMenu.vue'

export default Vue.extend({
  components: {
    CustomMenu
  },

  computed: {
    tab: {
      get () {
        return NoteState.collectTab()
      },
      set (tab) {
        NoteState.replaceTab(tab)
      }
    }
  }
})
</script>
