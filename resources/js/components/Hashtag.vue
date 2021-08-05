<template lang="pug">
  .hashtag.my-1
    router-link(:to="{ name: 'HashtagResult', params: { hashtag: hashtag.name }}") {{ `#${hashtag.name}` }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['hashtag']
})
</script>
