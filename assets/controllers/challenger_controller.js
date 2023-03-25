import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['challenge'];

    connect() {
        this.element.addEventListener('click', () => {
            this.challengeTarget.innerHTML = 'hello world'
        })
    }

    addChallenge() {
        console.log('work?');
        this.challengeTarget.innerHTML = 'criada';
    }
}
