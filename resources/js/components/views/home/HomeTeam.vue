<template lang="pug">
  router-link.home-team.no-hover.mb-3(:to="{ name: 'Team', params: { slug: team.slug } }")
    img.d-block.m-auto(:src="team.photo")
    .name.w-100.px-3.py-2.text-white {{ team.name }}
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  props: ['team']
})
</script>

<style lang="sass" scoped>
.home-team
  img
    height: 210px
    object-fit: cover
    transition: 0.5s
    border-top-left-radius: 8px
    border-top-right-radius: 8px
  .name
    font-size: 0.875rem
    background: #9ca7c1
  &:hover
    img
      filter: brightness(40%)
</style>
