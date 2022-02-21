/**
 * @package     Tabs
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class Tabs{
    constructor() {
        this.triggers = null;

        this.init();

		return this;
    }

    init() {
        const triggers = $('[data-tab-trigger]');

        if(triggers.length > 0){
            this.triggers = triggers;
            this.setObservers();
        }
    }

    setObservers() {

        this.triggers.each((idx, el) => {
            const trigger = $(el);

            if(trigger.length > 0){
                trigger.on('click', (e) => {
                    e.preventDefault();
                    
                    this.hide();
                    this.show($(e.target));
                });
            }
        });
    }

    show(el){
        if(el.length > 0){
            el.addClass('active');

            const content = $('[data-tab-content="' + el.data('tabTrigger') + '"]');

            if(content.length > 0){
                content.addClass('active');
            }
        }
    }

    hide(){
        const triggers = $('[data-tab-trigger]');

        if(triggers.length > 0){
            triggers.each((idx, el) => {
                const trigger = $(el);
                
                trigger.removeClass('active');

                if(trigger.length > 0){
                   const content = $('[data-tab-content="' + trigger.data('tabTrigger') + '"]');

                   if(content.length > 0){
                       content.removeClass('active');
                   }
                }
            });
        }   
    }
}