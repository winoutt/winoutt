<template lang="pug">
Icon.icon-record(name="record" v-if="canShow" )
</template>

<script lang="ts">
import Vue from 'vue'
import Icon from './Icon.vue'

export default Vue.extend({
  props: ['canShow'],
  components: {
    Icon
  }
})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.icon-record
  width: 6px !important
  height: 6px !important
  fill: $primary !important
</style>
