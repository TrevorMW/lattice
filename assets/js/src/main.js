import PopupWatcher from './core/popup-watcher';
import FieldWatcher from './core/field-watcher';
import MobileNav from './core/mobile-nav';
import AjaxFormWatcher from './core/ajax-form-watcher';


(() => { 
    "use strict";

    $(document).ready(() => {
        new AjaxFormWatcher();
        new PopupWatcher();
        new FieldWatcher();
        new MobileNav();
    })
})();