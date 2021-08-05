import $ from 'jquery'

export default {
  boot: function () {
    $(() => {
      $('[data-toggle="tooltip"]').tooltip()
    })
  }
}
