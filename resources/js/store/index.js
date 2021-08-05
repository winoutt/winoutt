import Vue from 'vue'
import Vuex from 'vuex'

import alert from './alertStore'
import sessionAlert from './sessionAlertStore'
import auth from './authStore'
import posts from './postsStore'
import users from './usersStore'
import teams from './teamsStore'
import notifications from './notificationsStore'
import messages from './messagesStore'
import chats from './chatsStore'
import settings from './settingsStore'
import hashtags from './hashtagsStore'
import notes from './notesStore'
import search from './searchStore'
import comment from './commentStore'
import app from './appStore'
import slider from './sliderStore'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    app,
    alert,
    sessionAlert,
    auth,
    posts,
    users,
    teams,
    notifications,
    messages,
    chats,
    settings,
    hashtags,
    notes,
    search,
    comment,
    slider
  }
})
