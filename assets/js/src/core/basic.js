import $ from 'jquery'; // eslint-disable-line no-unused-vars

export default class Basic{
    constructor() {
        this.init();
    }

    init() {
        const self = this;

        self.setObservers();
    }

    setObservers() {
        const self = this;

        $(document).ready(() => {

        });
    }
}
