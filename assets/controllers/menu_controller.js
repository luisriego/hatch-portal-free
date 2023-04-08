import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['options', 'button']

    toggle() {
        if (this.optionsTarget.classList.contains('hidden-xs')) {
            this.optionsTarget.classList.remove('hidden-xs')
        } else {
            this.optionsTarget.classList.add('hidden-xs')
        }
    }
}
