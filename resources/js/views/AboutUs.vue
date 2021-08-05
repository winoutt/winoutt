<template lang="pug">
  Article.about-us(title="About Us" :custom-sized="true")
  h5.mt-2
  strong The Short
  p Most people end up living mediocre lives. We created a social network that empowers you to upgrade your life and impact the world around you.
  h5.long
  strong The Long
  p.blockquote
  em All human beings are entrepreneurs. When we were in the caves, we were all self-employed…finding our food, feeding ourselves. That’s where human history began. As civilization came, we suppressed it. We became 'labor' because they stamped us, 'You are labor.' We forgot that we are entrepreneurs.
  | – Muhammad Yunus, Nobel Peace Prize winner and microfinance pioneer
  p Don't be burdened by conventional wisdom or dogma. You are born to do so much more than spend your time commuting through traffic to work a regular job, only to come back home to watch TV and sleep. Envision, for a moment, your unsuppressed self. If every seemingly insurmountable obstacle and limitation were removed, what would you do? More importantly, who would you be? If a resounding clarion call for the entrepreneur in you to rise up suddenly rang out, what app would you develop; what business enterprise would you start; what lifelong dream would materialize into reality?
  p At Oceanpace, we define a successful entrepreneurial venture as success after great difficulty. If an easy road to advancement existed, every business venture would thrive, all brilliant minds would produce prosperous lives, and poverty would be remedied. In fact, the road to greatness resembles a roller coaster. The conundrum is deciding whether or not to persevere past the urge to quit. Do you give up at the sight of ups, downs, twists, and turns? Oceanpace is here to help you to survive the ride, and enjoy the thrills and chills in the process.
  p.blockquote
  em Don’t try to do everything by yourself, but try to connect with people and resources. Having that discipline and perseverance is really important.
  | – Chieu Cao, Co-Founder & CMO of Perkbox
  p Oceanpace is a social networking platform that allows members to share their vision, ideas, experiences, and solve shared problems. Our platform esteems the authentic, business-building process of every member. Although your path is your path, we understand that true success is never a solo journey. Here, great minds are freed from the confines of filters and fakery. You are relieved from the smoke and mirror effects of other platforms. If you don’t know, asking is encouraged. Where a deficit exists, valuable support is available to fill the need. Maybe you have a colossal idea but lack capital. No worries; resources flow through relationships. Our community connects investors to ventures to form mutualistic partnerships.
  p We are a platform like you haven’t previously experienced. Oceanpace members don’t compete to outdo one another. Together, we pool our resources to compete with yesterday’s ideas, strategies, and practices to ensure a more productive present and profitable future.
  p.blockquote
  em Entrepreneurship doesn’t see age, color or gender. It rewards innovation, value, creativity, and effort.
  | – Patrick Bet-David, CEO and founder of PHP Agency, and the creator of the YouTube channel “Valuetainment”
  p With Oceanpace, the limits fall off, innovation is fueled, and excellence is achieved. We know entrepreneurship is challenging; we also know it to be an effective avenue for breaking free from adverse life circumstances. Within you is the budding tenacity and discipline needed to progress toward a future far more promising than paying bills and working for a weekend. The Oceanpace community is here to champion you to success! We overcome struggles and strive toward greatness together. Here, room is made for you to win…
  h5.slogan
  strong Do The Work. Make a Difference. Leave Your Mark.
</template>

<script lang="ts">
  import Vue from 'vue'
  import Article from '../components/Article.vue'

  export default Vue.extend({
    components: {
      Article
    }
  })
</script>

<style lang="sass" scoped>
  h5 font-size: 1.5rem line-height: 1.5 p font-size: 1.125rem line-height: 1.5 .slogan font-size: 1.125rem .blockquote margin-top: 15px padding-left: 17px border-left: 4px solid #D4D7DD

</style>
