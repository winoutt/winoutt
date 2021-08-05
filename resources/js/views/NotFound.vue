<template lang="pug">
  ErrorPage(code="404" description="Sorry, we couldn't find that page.")
</template>

<script lang="ts">
import Vue from 'vue'
import ErrorPage from '../components/ErrorPage.vue'

export default Vue.extend({
  components: {
    ErrorPage
  }
})
</script>
