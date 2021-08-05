<template lang="pug">
.search
  template(v-if="hasResults")
    HeadingSmall.my-3.text-break Search results for "{{ term }}"
    SearchHashtags.mt-2.mb-4(:hashtags="hashtags")
    SearchPeople.mb-4(:people="people")
    SearchPosts(:posts="posts")
  HeadingSmall.mt-3.text-break(v-else) No search results for "{{ term }}"
  PostModals
</template>

<script lang="ts">
import Vue from 'vue'
import { size } from 'lodash'
import SearchState from '../State/SearchState'
import HashtagState from '../State/HashtagState'
import PostState from '../State/PostState'
import UserState from '../State/UserState'

import HeadingSmall from '../components/heading/HeadingSmall.vue'
import SearchHashtags from '../components/views/search/SearchHashtags.vue'
import SearchPeople from '../components/views/search/SearchPeople.vue'
import SearchPosts from '../components/views/search/SearchPosts.vue'
import PostModals from '../components/post/PostModals.vue'

export default Vue.extend({
  components: {
    HeadingSmall,
    SearchHashtags,
    SearchPeople,
    SearchPosts,
    PostModals
  },

  beforeRouteEnter (to, from, next) {
    const term = SearchState.collectTerm()
    if (term) next()
    else next({ name: 'Home' })
  },

  beforeRouteLeave (to, from, next) {
    this.term = ''
    next()
  },

  computed: {
    term: {
      get () { return SearchState.collectTerm() },
      set (term) { SearchState.replaceTerm(term) }
    },
    hashtags () {
      return HashtagState.collectSearch()
    },
    people () {
      return UserState.collectSearch('global-search')
    },
    posts () {
      return PostState.collectPosts()
    },
    hasResults () {
      return size(this.hashtags) || size(this.people) || size(this.posts)
    }
  }
})
</script>
