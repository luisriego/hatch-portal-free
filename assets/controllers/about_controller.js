import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['vision', 'values', 'mission', 'visionBtn', 'valuesBtn', 'missionBtn']

    visionTab() {
        this.visionTarget.classList.add('in', 'active')
        this.valuesTarget.classList.remove('in', 'active')
        this.missionTarget.classList.remove('in', 'active')
        this.visionBtnTarget.classList.add('active')
        this.valuesBtnTarget.classList.remove('active')
        this.missionBtnTarget.classList.remove('active')
    }

    valuesTab() {
        this.visionTarget.classList.remove('in', 'active')
        this.valuesTarget.classList.add('in', 'active')
        this.missionTarget.classList.remove('in', 'active')
        this.visionBtnTarget.classList.remove('active')
        this.valuesBtnTarget.classList.add('active')
        this.missionBtnTarget.classList.remove('active')
    }

    missionTab() {
        this.visionTarget.classList.remove('in', 'active')
        this.valuesTarget.classList.remove('in', 'active')
        this.missionTarget.classList.add('in', 'active')
        this.visionBtnTarget.classList.remove('active')
        this.valuesBtnTarget.classList.remove('active')
        this.missionBtnTarget.classList.add('active')
    }
}
