<template lang="pug">
.col-md-60.col-lg-50.h-100
  .messages-sidebar.h-100
    HeadingSmall.mb-3.pt-3 Messages
    InputSmall.mb-3(placeholder="Search messages" @input="search()" v-model="term")
    CustomMenu.mb-2(:titles="['Active', 'Archived']" :values="['active', 'archived']" v-model="tab")
    MessagesChats
</template>

<script lang="ts">
import Vue from 'vue'
import { debounce } from 'lodash'
import ChatState from '../../../State/ChatState'
import ChatRequest from '../../../Request/ChatRequest'

import HeadingSmall from '../../heading/HeadingSmall.vue'
import InputSmall from '../../input/InputSmall.vue'
import CustomMenu from '../../CustomMenu.vue'
import MessagesChats from './MessagesChats.vue'
import Icon from '../../Icon.vue'
import MessageState from '../../../State/MessageState'

export default Vue.extend({
  components: {
    HeadingSmall,
    InputSmall,
    CustomMenu,
    MessagesChats,
    Icon
  },

  computed: {
    tab: {
      get () {
        return ChatState.collectTab()
      },
      set (tab) {
        ChatState.replaceTab(tab)
      }
    },
    unreadsCount () {
      return MessageState.collectUnreadsCount()
    }
  },

  data () {
    return {
      term: ''
    }
  },

  methods: {
    search: debounce(async function () {
      if (this.tab !== 'active') this.tab = 'active'
      if (!this.term) return ChatRequest.paginate()
      await ChatRequest.search({ term: this.term })
    }, 300)
  }
})
</script>
