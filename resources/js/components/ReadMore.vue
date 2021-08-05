<template lang="pug">
  .read-more(v-if="text" dir="auto")
    span(@click="clickContent()")
      component(:is="textComponent")
    span.ml-2(v-show="text.length > maxChars")
      a#readmore(:href="link" v-show="!isReadMore" @click="triggerReadMore($event, true)") {{ moreStr }}
      a#readmore(:href="link" v-show="isReadMore" @click="triggerReadMore($event, false)") {{ lessStr }}
</template>

<script>
export default {
  props: {
    moreStr: {
      type: String,
      default: '(more)'
    },
    lessStr: {
      type: String,
      default: '(less)'
    },
    text: { required: true },
    link: {
      type: String,
      default: '#'
    },
    maxChars: {
      type: Number,
      default: 100
    },
    previewLink: {
      type: String,
      default: null
    }
  },

  data () {
    return {
      isReadMore: false
    }
  },

  computed: {
    formattedString () {
      var text = this.text
      if (!this.isReadMore && this.text.length > this.maxChars) {
        text = text.substring(0, this.maxChars) + '...'
      }
      return text
    },
    textComponent () {
      return { template: this.Util.linkify(this.formattedString, this.previewLink) }
    }
  },

  methods: {
    triggerReadMore (event, isReadMore) {
      if (this.link === '#') event.preventDefault()
      if (this.lessStr !== null || this.lessStr !== '') {
        this.isReadMore = isReadMore
      }
    },
    clickContent () {
      this.$emit('clickContent')
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../../sass/variables'

#readmore
  color: #1A5FAA
</style>
