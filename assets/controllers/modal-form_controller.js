import { Controller} from '@hotwired/stimulus'
import { Modal } from 'bootstrap'

export default class extends Controller {
    static targets = ['modal', 'modalBody']
    static values = {
        formUrl: String,
    }

    inputValue = ''

    async openModal(event) {
        event.preventDefault()
        this.modalBodyTarget.innerHTML = 'Loading ...'
        const modal = new Modal(this.modalTarget)
        modal.show()

        const params = new URLSearchParams({
            url: this.inputValue
        })

        const response = await fetch(`${this.formUrlValue}?url=${this.inputValue.toString()}`)
        this.modalBodyTarget.innerHTML = await response.text()
    }

    onInput(event) {
        this.inputValue = event.currentTarget.value
        console.log(this.inputValue);
    }
}