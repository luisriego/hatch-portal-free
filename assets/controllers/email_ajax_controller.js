import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String,
    }

    async onEmailInput(event) {
        event.preventDefault()
        const params = new URLSearchParams({
            q: event.currentTarget.value,
            preview: 1
        })
        const response = await fetch(`${this.urlValue}?${params.toString()}`)
    }
}
