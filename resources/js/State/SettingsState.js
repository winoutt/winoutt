import State from './State'

export default {
  collectActive () {
    return State.store.getters['settings/active']
  },

  collectIsDarkMode () {
    return State.store.getters['settings/isDarkMode']
  },

  collectIsEnabledNotification () {
    return State.store.getters['settings/isEnabledNotification']
  },

  collectSettings () {
    return State.store.getters['settings/settings']
  },

  collectUser () {
    return State.store.getters['settings/user']
  },

  collectFirstName () {
    return State.store.getters['settings/firstName']
  },

  collectLastName () {
    return State.store.getters['settings/lastName']
  },

  collectEmail () {
    return State.store.getters['settings/email']
  },

  collectUsername () {
    return State.store.getters['settings/username']
  },

  collectBio () {
    return State.store.getters['settings/bio']
  },

  collectCompanyWebsite () {
    return State.store.getters['settings/companyWebsite']
  },

  collectPersonalWebsite () {
    return State.store.getters['settings/personalWebsite']
  },

  collectDateOfBirth () {
    return State.store.getters['settings/dateOfBirth']
  },

  collectGender () {
    return State.store.getters['settings/gender']
  },

  collectCity () {
    return State.store.getters['settings/city']
  },

  collectCountry () {
    return State.store.getters['settings/country']
  },

  collectAvatar () {
    return State.store.getters['settings/avatar']
  },

  collectTitle () {
    return State.store.getters['settings/title']
  },

  collectCustomTitle () {
    return State.store.getters['settings/customTitle']
  },

  isUserUnsaved () {
    return State.store.getters['settings/isUserUnsaved']
  },

  replaceActive (active) {
    State.store.commit('settings/replaceActive', active)
  },

  replaceDarkMode (isDarkMode) {
    State.store.commit('settings/replaceDarkMode', isDarkMode)
  },

  replaceEnableNotification (isEnabled) {
    State.store.commit('settings/replaceEnableNotification', isEnabled)
  },

  replaceSettings (settings) {
    State.store.commit('settings/replaceSettings', settings)
  },

  replaceUser (user) {
    State.store.commit('settings/replaceUser', user)
  },

  replaceFirstName (firstName) {
    State.store.commit('settings/replaceFirstName', firstName)
  },

  replaceLastName (lastName) {
    State.store.commit('settings/replaceLastName', lastName)
  },

  replaceEmail (email) {
    State.store.commit('settings/replaceEmail', email)
  },

  replaceUsername (username) {
    State.store.commit('settings/replaceUserName', username)
  },

  replaceBio (bio) {
    State.store.commit('settings/replaceBio', bio)
  },

  replaceCompanyWebsite (companyWebsite) {
    State.store.commit('settings/replaceCompanyWebsite', companyWebsite)
  },

  replacePersonalWebsite (personalWebsite) {
    State.store.commit('settings/replacePersonalWebsite', personalWebsite)
  },

  replaceDateOfBirth (dateOfBirth) {
    State.store.commit('settings/replaceDateOfBirth', dateOfBirth)
  },

  replaceGender (gender) {
    State.store.commit('settings/replaceGender', gender)
  },

  replaceCity (city) {
    State.store.commit('settings/replaceCity', city)
  },

  replaceCountry (country) {
    State.store.commit('settings/replaceCountry', country)
  },

  replaceAvatar (avatar) {
    State.store.commit('settings/replaceAvatar', avatar)
  },

  replaceTitle (title) {
    State.store.commit('settings/replaceTitle', title)
  },

  replaceCustomTitle (customTitle) {
    State.store.commit('settings/replaceCustomTitle', customTitle)
  }
}
