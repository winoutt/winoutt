<template lang="pug">
.connection-request-buttons.d-flex
  ButtonSmall.align-self-start.mr-2(
    text="Ignore"
    link="true"
    @click.native.prevent="ignore()"
  )
  ButtonSmall.accept-button.align-self-start(
    text="Accept"
    @click.native.prevent="accept()"
  )
</template>

<script lang="ts">
import Vue from 'vue'
import ButtonSmall from './button/ButtonSmall.vue'
export default Vue.extend({
  components: {
    ButtonSmall
  },

  methods: {
    ignore () {
      this.$emit('ignore')
    },
    accept () {
      this.$emit('accept')
    }
  }
})
</script>

<style lang="sass" scoped>

</style>
