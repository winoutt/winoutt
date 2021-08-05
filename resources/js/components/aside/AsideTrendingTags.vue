<template lang="pug">
  AsideCard.aside-trending-tags(v-if="!Util.isEmpty(hashtags)")
    template(v-slot:card-body)
      .trending-body
        AsideHeading(heading="Trending tags")
        Hashtag.hashtag(v-for="hashtag in hashtags" :key="hashtag.id" :hashtag="hashtag")
</template>

<script lang="ts">
import Vue from 'vue'
import HashtagState from '../../State/HashtagState'

import AsideCard from './AsideCard.vue'
import AsideHeading from './AsideHeading.vue'
import Hashtag from '../Hashtag.vue'

export default Vue.extend({
  components: {
    AsideCard,
    AsideHeading,
    Hashtag
  },

  computed: {
    hashtags () {
      return HashtagState.collectHashtags()
    }
  }
})
</script>

<style lang="sass" scoped>
.aside-trending-tags
  margin-bottom: 31px
.hashtag
  font-size: 0.875rem
  line-height: 1.4rem
.trending-body
  margin-bottom: 10px
</style>
