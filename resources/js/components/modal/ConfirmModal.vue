<template lang="pug">
  Modal(:title="title")
    template(v-slot:body)
      slot
    template(v-slot:footer)
      .actions.d-flex.justify-content-end
        Button.mr-2(text="Cancel" :secondary="true" @click.native="cancel()")
        Button(text="Yes" @click.native="confirm()")
</template>

<script lang="ts">
import Vue from 'vue'

import Modal from './Modal.vue'
import Button from '../button/Button.vue'

export default Vue.extend({
  props: ['title'],
  components: {
    Modal,
    Button
  },

  methods: {
    cancel () {
      this.$emit('cancel')
    },
    confirm () {
      this.$emit('confirm')
    }
  }
})
</script>
