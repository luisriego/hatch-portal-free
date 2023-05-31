import { Controller} from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['language']

    toggle() {
        if (this.element.childNodes[1][0].classList.contains('active')) {
            this.element.childNodes[1][0].classList.remove('active')
            this.element.childNodes[1][1].classList.add('active')
            this.element.childNodes[1][0].removeAttribute('selected')
            this.element.childNodes[1][1].setAttribute('selected', true)
        } else {
            this.element.childNodes[1][0].classList.add('active')
            this.element.childNodes[1][1].classList.remove('active')
            this.element.childNodes[1][1].removeAttribute('selected')
            this.element.childNodes[1][0].setAttribute('selected', true)
        }

    }
}