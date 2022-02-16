/**
 * @package     Accordion
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class Accordion{
    constructor() {
        this.triggers = null;

        this.init();

		return this;
    }

    init() {
        const triggers = $('[data-accordion-trigger]');

        if(triggers.length > 0){
            this.triggers = triggers;

            this.setObservers();
        }
    }

    setObservers() {

        this.triggers.each((idx, el) => { 
            const trigger = $(el);

            if(trigger.length > 0) {
                trigger.on('click', (e) => {
                    e.preventDefault();

                    const trigger = $(e.target),
                          parent  = trigger.closest('[data-accordion-item]');

                    if(parent.length > 0){                        
                        if(parent.hasClass('active')){
                            this.close(parent, trigger);
                        } else {
                            this.open(parent, trigger);
                        }
                    } 
                });
            }
        });

    }

    open(el, trigger){
        $(document).trigger('core:accordion:beforeOpen', { el: el});
        el.addClass('active');
        trigger.attr('aria-expanded', true);
        $(document).trigger('core:accordion:afterOpen', { el: el});
    }

    close(el, trigger){
        $(document).trigger('core:accordion:beforeClose', { el: el});
        el.removeClass('active');
        trigger.attr('aria-expanded', false);
        $(document).trigger('core:accordion:afterClose', { el: el});
    }
}