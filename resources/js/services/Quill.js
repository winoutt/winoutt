import Quill from 'quill'

export default {
  link () {
    var link = Quill.import('formats/link')
    class httpLink extends link {
      static create (value) {
        const node = super.create(value)
        value = this.sanitize(value)
        if (!value.startsWith('http')) value = 'http://' + value
        node.setAttribute('href', value)
        return node
      }
    }
    Quill.register(httpLink)
  }
}
