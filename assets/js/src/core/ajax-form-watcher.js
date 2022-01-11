import AjaxForm from './ajax-form';
import FormMsg from './form-message';

/**
 * @package     Ajax Form Watcher
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class AjaxFormWatcher{
    constructor() {
        this.init();

		return this;
    }

    init() {
        this.setObservers();

        $(document).on('core:popup:content:loaded', () => {
            this.setObservers();
        });
    }

    setObservers() {
        const self  = this;
        const forms = $('[data-ajax-form]');

        if(forms.length > 0){
            const ajaxForm = new AjaxForm();
            const formMsg  = new FormMsg();

            ajaxForm.setObservers();
            formMsg.setObservers();

        }   
    }
}