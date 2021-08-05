<template lang="pug">
.spinner.position-relative
  #spinner
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({

})
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

.spinner
  height: 30px
  width: 30px

#spinner
  animation: rotateAnimation 1.5s linear infinite
  clip: rect(0, 20px, 20px, 10px)
  position: absolute
  height: 20px
  width: 20px

@keyframes rotateAnimation
  0%
    transform: rotate(0deg)
  100%
    transform: rotate(220deg)

#spinner:after
  animation: increaseHeightAnimation 1.5s ease-in-out infinite
  clip: rect(0, 20px, 20px, 10px)
  content:''
  border-radius: 50%
  height: 20px
  width: 20px
  position: absolute

@keyframes increaseHeightAnimation
  0%
    box-shadow: inset $primary 0 0 0 5px
    transform: rotate(-140deg)
  50%
    box-shadow: inset $primary 0 0 0 1px
  100%
    box-shadow: inset $primary 0 0 0 5px
    transform: rotate(140deg)
</style>
