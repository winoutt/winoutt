<template lang="pug">
  .youtube-player.embed-responsive.embed-responsive-16by9.rounded(v-if="videoId")
    iframe(
      :src="`https://www.youtube.com/embed/${videoId}`"
      frameborder="0"
      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    )
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['content'],
  computed: {
    videoId () {
      return this.Util.youtubeVideoId(this.content)
    }
  }
})
</script>
