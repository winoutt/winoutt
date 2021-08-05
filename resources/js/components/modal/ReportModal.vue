<template lang="pug">
  Modal(:title="title")
    template(v-slot:body)
      h6 What's wrong with this {{ type }}?
      Select.mb-3(v-model="reporting.category")
        option(value="" disabled selected) Please choose a reason
        option(v-if="isUser" value="mimic") Impersonating someone
        option(v-if="isUser" value="fake") Does not represent a real person
        option(value="rude") Rude, vulgar or uses bad language
        option(value="explicit") Sexually explicit
        option(value="harassment") Harassment or hate speech
        option(value="violent") Threatening, violent or suicidal
        option(value="other") Something else
      h6 Message
      Textarea(
        :data-value="reporting.message"
        v-max-character="500"
        placeholder="Type your message..."
        rows="3"
        v-model="reporting.message"
      )
    template(v-slot:footer)
      .actions.d-flex.justify-content-end
        Button.mr-2(text="Cancel" :secondary="true" @click.native="cancel()")
        Button(text="Report" @click.native="report()")
</template>

<script lang="ts">
import Vue from 'vue'
import ReportingRequest from '../../Request/ReportingRequest'
import maxCharacter from '../../directives/maxCharacter'

import Modal from './Modal.vue'
import Select from '../select/Select.vue'
import Textarea from '../Textarea.vue'
import Button from '../button/Button.vue'
import PostModalService from '../../services/ModalServices/PostModalService'
import CommentModalService from '../../services/ModalServices/CommentModalService'
import UserModalService from '../../services/ModalServices/UserModalService'

export default Vue.extend({
  props: ['type', 'data'],
  components: {
    Modal,
    Select,
    Textarea,
    Button
  },

  directives: {
    maxCharacter
  },

  data () {
    return {
      reporting: {
        id: null,
        type: this.type,
        category: '',
        message: ''
      }
    }
  },

  computed: {
    title () {
      return `Report ${this.type}`
    },
    isUser () {
      return this.type === 'user'
    }
  },

  methods: {
    cancel () {
      this.$emit('cancel')
    },
    async report () {
      this.reporting.id = this.data.id
      const response = await ReportingRequest.create(this.reporting)
      if (!response) return
      this.$emit('report')
    },
    clear () {
      this.reporting = {
        id: null,
        type: this.type,
        category: '',
        message: ''
      }
    },
    onClose () {
      if (this.type === 'post') {
        PostModalService.report().onClose(() => {
          this.clear()
        })
      } else if (this.type === 'comment') {
        CommentModalService.report().onClose(() => {
          this.clear()
        })
      } else if (this.type === 'user') {
        UserModalService.report().onClose(() => {
          this.clear()
        })
      }
    }
  },

  mounted () {
    this.onClose()
  }
})
</script>
