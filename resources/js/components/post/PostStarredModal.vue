<template lang="pug">
  Modal#post-starred-modal(title="Starred by")
    template(v-slot:body)
      .starred
        UserStarred(v-for="user in starred" :key="user.id" :user="user")
    template(v-slot:footer)
      Button.ml-auto.d-block(text="Done" @click.native="done()")
</template>

<script lang="ts">
import Vue from 'vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import UserState from '../../State/UserState'
import PostState from '../../State/PostState'
import UserScroll from '../../Scroll/UserScroll'

import Modal from '../modal/Modal.vue'
import UserStarred from '../user/UserStarred.vue'
import Button from '../button/Button.vue'

export default Vue.extend({
  components: {
    Modal,
    UserStarred,
    Button
  },

  computed: {
    starred () {
      return UserState.collectPostStars()
    }
  },

  methods: {
    done () {
      PostModalService.starred().close()
    },
    onOpen () {
      PostModalService.starred().onOpen(() => {
        const post = PostState.collectStarredModal()
        UserScroll.starred.paginate.listen(post.id)
      })
    },
    onClose () {
      PostModalService.starred().onClose(() => {
        UserScroll.starred.paginate.leave()
      })
    }
  },

  mounted () {
    this.onOpen()
    this.onClose()
  }
})
</script>
