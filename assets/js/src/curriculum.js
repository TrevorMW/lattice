import PopupWatcher from './core/popup-watcher';
import FieldWatcher from './core/field-watcher';
import MobileNav from './core/mobile-nav';
import AjaxFormWatcher from './core/ajax-form-watcher';
import Accordion from './core/accordion';
import Tabs from './core/tabs';
import Curriculum from './core/curriculum';

(() => { 
    "use strict";

    $(document).ready(() => {
      new MobileNav();
      new AjaxFormWatcher();
      new PopupWatcher();
      new FieldWatcher();  
      new Accordion();
      new Tabs();
      new Curriculum();
    })
})();