<template lang="pug">
  Alert(v-if="action.buttonText" @click.native="clear()")
    .action.text-uppercase.text-primary(@click="runHandler()") {{ action.buttonText }}
</template>

<script lang="ts">
import Vue from 'vue'
import AlertState from '../../State/AlertState'

import Alert from './Alert.vue'

export default Vue.extend({
  components: {
    Alert
  },

  computed: {
    action () {
      return AlertState.collectAction()
    }
  },

  methods: {
    clear () {
      AlertState.pullAction()
    },
    runHandler () {
      this.action.handler()
    }
  }
})
</script>

<style lang="sass" scoped>
.action
  font-size: 0.93em
  margin-left: 23px
  font-weight: 500
</style>
