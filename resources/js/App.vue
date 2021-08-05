<template>
  <div class="h-100">
    <div id="progress"></div>
    <Alert v-if="canShowAlert"/>
    <AlertAction />
    <Panel v-if="isAuthPage && hasAuth">
      <PanelContentOneColumn v-if="col === 1">
        <router-view></router-view>
      </PanelContentOneColumn>
      <template v-if="col === 2">
        <PanelContentTwoColumn v-if="isFullWidth">
          <router-view></router-view>
        </PanelContentTwoColumn>
        <PanelContentTwoColumnSqueezed v-else>
          <router-view></router-view>
        </PanelContentTwoColumnSqueezed>
      </template>
    </Panel>
    <PanelPublic v-else-if="isAuthPage && !hasAuth">
      <router-view></router-view>
    </PanelPublic>
    <router-view v-else></router-view>
  </div>
</template>

<script>
import { isEmpty } from 'lodash'

import Progress from './services/Progress'
import Alert from './components/alert/Alert'
import AlertAction from './components/alert/AlertAction'
import SettingsState from './State/SettingsState'
import AlertState from './State/AlertState'
import AuthToken from './services/AuthToken'
import Darkmode from './services/Darkmode'

import Panel from './components/panel/Panel.vue'
import PanelPublic from './components/panel/PanelPublic.vue'
import PanelContentOneColumn from './components/panel/PanelContentOneColumn'
import PanelContentTwoColumn from './components/panel/PanelContentTwoColumn'
import PanelContentTwoColumnSqueezed from './components/panel/PanelContentTwoColumnSqueezed'

export default {
  components: {
    Alert,
    AlertAction,
    Panel,
    PanelPublic,
    PanelContentOneColumn,
    PanelContentTwoColumn,
    PanelContentTwoColumnSqueezed
  },

  computed: {
    isFullWidth () {
      return this.$route.meta.fullWidth
    },
    isAuthPage () {
      return this.$route.meta.auth
    },
    isDarkModePage () {
      return this.$route.meta.darkMode
    },
    hasAuth () {
      return AuthToken.has()
    },
    canShowAlert () {
      const action = AlertState.collectAction()
      return isEmpty(action.buttonText)
    },
    col () {
      return this.$route.meta.col
    },
    isEnabledDarkMode () {
      return SettingsState.collectIsDarkMode()
    }
  },

  watch: {
    isDarkModePage (val) {
      Darkmode.toggle(this.isDarkModePage, this.isEnabledDarkMode)
    },
    isEnabledDarkMode () {
      Darkmode.toggle(this.isDarkModePage, this.isEnabledDarkMode)
    }
  },

  methods: {
    initProgress () {
      Progress.initialize()
    }
  },

  mounted () {
    this.initProgress()
  }
}
</script>

<style lang="sass">
html,
body
  height: 100%
#progress
  width: 100%
  height: 3px
  position: fixed
  top: 0
  z-index: 1055
</style>
