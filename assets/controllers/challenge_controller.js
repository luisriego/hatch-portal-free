import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['text', 'buttonPlus', 'buttonNext']

    textAction() {
        if (this.textTarget.childNodes[3].value.length !== 0) {
            this.buttonPlusTarget.childNodes[1].disabled = false
            this.buttonNextTarget.childNodes[1].disabled = false
        }
    }
}
