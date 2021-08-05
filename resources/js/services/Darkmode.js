import $ from 'jquery'

export default {
  toggle (isDarkModePage, isEnabledDarkMode) {
    const isDarkMode = isDarkModePage && isEnabledDarkMode
    isDarkMode
      ? $('body').addClass('dark-mode')
      : $('body').removeClass('dark-mode')
  }
}
