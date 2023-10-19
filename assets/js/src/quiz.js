import PopupWatcher from './core/popup-watcher';
import FieldWatcher from './core/field-watcher';
import MobileNav from './core/mobile-nav';
import AjaxFormWatcher from './core/ajax-form-watcher';
import Quiz from './core/ajax-quiz';
import Accordion from './core/accordion';

(() => { 
    "use strict";

    $(document).ready(() => {
      new MobileNav();
      new AjaxFormWatcher();
      new Quiz();
      new PopupWatcher();
      new FieldWatcher();
      
      $(document).on('core:quiz:results', () => {
        new Accordion();
      })
    })
})();



