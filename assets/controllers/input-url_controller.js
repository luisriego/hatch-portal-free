import { Controller} from '@hotwired/stimulus'
import { Modal } from 'bootstrap'
import $ from "jquery";

export default class extends Controller {
    inputValue = ''
    static targets = ['modal', 'modalBody']
    static values = {
        formUrl: String,
    }

    async openModal(event) {
        // event.preventDefault()
        this.modalBodyTarget.innerHTML = 'Loading ...'
        const modal = new Modal(this.modalTarget)
        modal.show()

        this.modalBodyTarget.innerHTML = await fetch(this.formUrlValue)
        // this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue)
    }

    onInput(event) {
        this.inputValue = event.currentTarget.value
        console.log(this.inputValue);
    }
}