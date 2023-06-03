import { Controller} from '@hotwired/stimulus'
import { Modal } from 'bootstrap'


export default class extends Controller {
    static targets = ['modal', 'modalBody']
    static values = {
        formUrl: String,
    }

    inputValue = ''

    async openModal(event) {
        // event.preventDefault()
        this.modalBodyTarget.innerHTML = 'Loading ...'
        const modal = new Modal(this.modalTarget)
        modal.show()

        const response = await fetch(`${this.formUrlValue}?url=${this.inputValue.toString()}`)
        this.modalBodyTarget.innerHTML = await response.text()
    }

    onInput(event) {
        this.inputValue = event.currentTarget.value
    }

    deleteNews() {

    }
    //
    // async submitForm() {
    //     const form = this.modalBodyTarget.getElementsByTagName('form')[0]
    //     const response = await fetch(`${this.formUrlValue}?url=""`, {
    //         method: form.method,
    //         body: new URLSearchParams(new FormData(form))
    //     })
    //     console.log(form.method, response);
    // }
}