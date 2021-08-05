<template lang="pug">
  Modal#poll-create-modal(title="Create poll")
    template(v-slot:body)
      .poll
        .choices.d-flex.justify-content-between.mb-2
          .choices-wrapper.w-100
            Input.mr-2.mb-3(placeholder="Ask a question..." v-model="question")
            .choice(v-for="(choice, index) in choices" :key="index")
              Input.mr-2(:placeholder="`Choice ${index + 1}`" v-model="choice.value")
          Icon.icon-add.cursor-pointer.align-self-end(name="add" @click.native="addChoice()" :class="canHideAddIcon ? 'invisible' : '' ")
        .duration
          h6.font-weight-bold Poll duration
          .row.no-gutters
            .col-md.pr-md-3
              label.font-weight-bold Days
              Select(v-model="duration.days")
                option(v-for="day in 8" :value="day - 1") {{ day - 1 }}
            .col-md.pr-md-3
              label.font-weight-bold Hours
              Select(v-model="duration.hours")
                option(v-for="hour in 13" :value="hour - 1") {{ hour - 1 }}
            .col-md
              label.font-weight-bold Minutes
              Select(v-model="duration.minutes")
                option(v-for="minute in 61" :value="minute - 1") {{ minute - 1 }}
    template(v-slot:footer)
      Button.ml-auto.d-block(text="Create" @click.native="create()" :disabled="!canCreate")
</template>

<script lang="ts">
import Vue from 'vue'
import { compact, map, size, reject } from 'lodash'
import moment from 'moment'
import PollModalService from '../../services/ModalServices/PollModalService'

import Modal from '../modal/Modal.vue'
import Input from '../input/Input.vue'
import Icon from '../Icon.vue'
import Select from '../select/Select.vue'
import Button from '../button/Button.vue'

export default Vue.extend({
  components: {
    Modal,
    Input,
    Icon,
    Select,
    Button
  },

  data () {
    return {
      question: '',
      choices: [
        { value: '' },
        { value: '' }
      ],
      duration: {
        days: 1,
        hours: 0,
        minutes: 0
      }
    }
  },

  computed: {
    canHideAddIcon () {
      return size(this.choices) === 5
    },
    canCreate () {
      const choices = compact(map(this.choices, choice => choice.value))
      const isEndAtValid = moment().isBefore(this.getEndAt())
      return this.question && choices.length >= 2 && isEndAtValid
    }
  },

  methods: {
    getEndAt () {
      return moment()
        .add(this.duration.days, 'days')
        .add(this.duration.hours, 'hours')
        .add(this.duration.minutes, 'minutes')
        .format()
    },
    generateContent () {
      const choices = reject(this.choices, { value: '' })
      const content = {
        question: this.question,
        choices,
        end_at: this.getEndAt()
      }
      return content
    },
    create () {
      this.$emit('input', this.generateContent())
      PollModalService.create().close()
    },
    addChoice () {
      if (this.choices.length === 5) return
      this.choices.push({ value: '' })
    },
    clear () {
      this.question = ''
      this.choices = [
        { value: '' },
        { value: '' }
      ]
      this.duration = {
        days: 1,
        hours: 0,
        minutes: 0
      }
    },
    onClose () {
      PollModalService.create().onClose(() => {
        this.clear()
      })
    }
  },

  mounted () {
    this.onClose()
  }
})
</script>

<style lang="sass" scoped>
.choices
  .icon-add
    width: 20px
    height: 18px
    margin-bottom: 15px

.duration
  label
    font-size: 0.75rem
</style>
