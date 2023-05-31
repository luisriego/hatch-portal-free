import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    areaState = false
    titleState = false
    subtitleState = false
    locationState = false
    static targets = ['button', 'area', 'title', 'subtitle', 'location']
    static values = {
        complete: Boolean,
    }

    areaBtn() {
        this.areaState = this.areaTarget.childNodes[3].value.length !== 0
        this.toggleButton()
    }

    titleBtn() {
        this.titleState = this.titleTarget.childNodes[3].value.length !== 0
        this.toggleButton()
    }

    subtitleBtn() {
        this.subtitleState = this.subtitleTarget.childNodes[3].value.length !== 0
        this.toggleButton()
    }

    locationBtn() {
        this.locationState = this.locationTarget.childNodes[3].value.length !== 0
        this.toggleButton()
    }

    toggleButton() {
        if (this.areaState && this.titleState && this.subtitleState && this.locationState) {
            this.buttonTarget.childNodes[1].disabled = false
        }

    }
}
