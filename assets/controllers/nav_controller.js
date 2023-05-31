import { Controller} from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['menu']

    toggle(event) {
        if (this.element.childNodes[1][0].classList.contains('collapse')) {
            this.element.childNodes[1][0].classList.remove('collapse')
            this.element.childNodes[1][0].classList.add('in')
        } else {
            this.element.childNodes[1][0].classList.remove('in')
            this.element.childNodes[1][0].classList.add('collapse')
        }
    }
}