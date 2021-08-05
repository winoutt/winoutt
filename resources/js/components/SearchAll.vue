<template lang="pug">
  InputSearch.mb-0.search-global(placeholder="Search" @input="search()" v-model="term")
</template>

<script lang="ts">
import Vue from 'vue'
import { debounce } from 'lodash'
import SearchRequest from '../Request/SearchRequest'
import SearchState from '../State/SearchState'

import InputSearch from './input/InputSearch.vue'

export default Vue.extend({
  components: {
    InputSearch
  },

  computed: {
    term: {
      get () { return SearchState.collectTerm() },
      set (term) { SearchState.replaceTerm(term) }
    }
  },

  methods: {
    search: debounce(async function () {
      await SearchRequest.all()
    }, 300)
  }
})
</script>
