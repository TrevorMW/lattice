import Popup from './core/popup';
import CouponCode from './core/coupon';

/**
 * @package     ModalSignup
 * @version     1.0
 * @author      Trevor Wagner
 */
export default class ModalSignup {
    constructor() {
        this.triggers = null;

        this.init();

        return this;
    }

    init() {
        const triggers = $('[data-start-quiz-modal]');
        const shouldLoad = triggers.data('startQuizModal');

        if (triggers.length > 0 && !shouldLoad) {
            this.triggers = triggers;
            this.setObservers();
        }
    }

    setObservers() {
        const self = this;

        this.triggers.each((idx, el) => {
            const trigger = $(el);

            if (trigger.length > 0) {
                trigger.on('click', (e) => {
                    e.preventDefault();

                    self.loadSignupModalData();
                });
            }
        });
    }

    loadSignupModalData() {
        const self = this;
        const popup = new Popup($('[data-popup]'), 'homepage_quiz_signup', 'Sign Up to take our Quiz!');
        
        $(document).trigger('core:popup:show');

        $(document).on('core:popup:contentLoaded', function () {
            const couponField = $('[data-program-coupon-code]');

            if (couponField.length > 0) {
                new CouponCode(couponField);  
            }
            
        })

        
    }
}