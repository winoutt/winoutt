<template lang="pug">
  .search-hashtags
    template(v-if="hashtags.length")
      h6.font-weight-bold.mb-3 Tags
      Hashtag(v-for="hashtag in hashtags" :key="hashtag.id" :hashtag="hashtag")
</template>

<script lang="ts">
import Vue from 'vue'
import Hashtag from '../../Hashtag.vue'

export default Vue.extend({
  props: ['hashtags'],
  components: {
    Hashtag
  }
})
</script>

<style lang="sass" scoped>
h6
  font-size: 1.125rem
</style>
