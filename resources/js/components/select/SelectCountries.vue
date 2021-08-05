<template lang="pug">
  SelectSmall(:value="value" @input="input")
    option(value="" selected disabled) Please select
    option(v-for="country in countries" :value="country.key") {{ country.name }}
</template>

<script lang="ts">
import Vue from 'vue'
import { forEach, orderBy } from 'lodash'
import CountriesList from 'countries-list'
import SelectSmall from './SelectSmall.vue'

export default Vue.extend({
  props: ['value'],
  components: {
    SelectSmall
  },

  computed: {
    countries () {
      var countries = forEach(
        CountriesList.countries,
        (country, key) => { country.key = key }
      )
      countries = orderBy(CountriesList.countries, ['name'], ['asc'])
      return countries
    }
  },

  methods: {
    input (value) {
      this.$emit('input', value)
    }
  }
})
</script>
