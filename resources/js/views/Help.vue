<template lang="pug">
  Article(title="Get help with Oceanpace")
  .row
  .col-md-138.offset-md-3.col-lg-108.offset-lg-18.col-xl-100.offset-xl-22
  .row.mb-3
  .col-md-72
  label.font-weight-bold Name
  InputLarge.mb-3(
  v-model="form.name"
  :data-value="form.name"
  v-max-character="40"
  required-field="true"
  )
  label.font-weight-bold Email
  InputLarge.mb-3(
  v-model="form.email"
  :data-value="form.email"
  v-max-character="30"
  required-field="true"
  )
  label.font-weight-bold Subject
  InputLarge.mb-3(
  v-model="form.subject"
  :data-value="form.subject"
  v-max-character="60"
  required-field="true"
  )
  .col-md-72
  label.font-weight-bold How can we help?
  Textarea.mb-3.textarea(
  placeholder="Write your message..."
  v-model="form.message"
  :data-value="form.message"
  v-max-character="2500"
  required-field="true"
  )
  .row
  .col-md-36.offset-md-54
  ButtonLarge(text="Send" @click.native="send()")
</template>

<script lang="ts">
  import Vue from 'vue'
  import ContactRequest from '../Request/ContactRequest'
  import Validate from '../services/Validate'
  import Alert from '../services/Alert'
  import ReCaptcha from '../services/ReCaptcha'

  import Article from '../components/Article.vue'
  import InputLarge from '../components/input/InputLarge.vue'
  import Textarea from '../components/Textarea.vue'
  import ButtonLarge from '../components/button/ButtonLarge.vue'

  export default Vue.extend({
    components: {
      Article,
      InputLarge,
      Textarea,
      ButtonLarge
    },

    data() {
      return {
        form: {
          name: '',
          email: '',
          subject: '',
          message: ''
        }
      }
    },

    methods: {
      clear() {
        this.form = {
          name: '',
          email: '',
          subject: '',
          message: ''
        }
      },
      async send() {
        if (!Validate.isFilledRequiredFields()) {
          return Alert.error(Validate.message.completeRequiredFields)
        }
        const isSent = await ContactRequest.contact(this.form)
        if (isSent) this.clear()
      }
    },

    mounted() {
      ReCaptcha.initialize()
    },

    beforeDestroy() {
      ReCaptcha.dispose()
    }
  })
</script>

<style lang="sass" scoped>
  label font-size: 1rem .textarea height: 134px

</style>
