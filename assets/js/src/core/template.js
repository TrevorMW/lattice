import $ from 'jquery';

export default class Templates{
    constructor() {
        this.init();

        return this;
        
    }

    init(){
        const self = this;

        self.setObservers();
    }

    setObservers() {
        const self = this;


        $(document).ready(() => {

        });
    }
}
