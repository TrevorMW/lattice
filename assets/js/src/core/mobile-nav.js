
/**
 * @package     MobileNav
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class MobileNav{
    constructor() {
        this.mobileNav = {
            trigger:null,
            el:null,
            navPanel:null,
            destroy:null,
            signout:null
        }

        this.init();

		return this;
    }

    init() {
        const self    = this;
        const trigger = $('[data-mobile-nav-trigger]');

        if( trigger.length > 0 ){
            const panel = $('[data-mobile-nav]');

            self.mobileNav.trigger = trigger;

            if(panel.length > 0){
                const destroy = $('[data-mobile-nav-close-trigger]');
                const signout = $('[data-sign-out]');
           
                self.mobileNav.el = panel;

                if(destroy.length > 0){
                    self.mobileNav.destroy = destroy;
                }

                if(signout.length > 0 ){
                    self.mobileNav.signout = signout;
                }

                this.setObservers();
            }
        }
    }

    setObservers() {
        const self = this;
        
        self.mobileNav.trigger.on('click', (e) => {
            e.preventDefault();

            if(!self.mobileNav.el.hasClass('active')){
                self.open();
            } else {
                self.close();
            }
        });

        self.mobileNav.destroy.on('click', (e) => { 
            e.preventDefault();
            self.close();
        });
    }

    open(){
        const self = this;
        self.lockBody(true);
        self.mobileNav.el.addClass('active');
    }

    close(){
        const self = this;

        self.lockBody(false);
        self.mobileNav.el.removeClass('active');
    }

    lockBody(lockIt){
		lockIt ? $('body').addClass('locked') : $('body').removeClass('locked');
	}
}