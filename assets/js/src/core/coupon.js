/**
 * @package     CouponCode
 * @version     1.0
 * @author      Trevor Wagner
 */
export default class CouponCode {
    constructor(couponField) {
        this.couponField = null;
        this.form = null;
        this.loader = null;
        this.msg = null;

        this.init(couponField);

        return this;
    }

    init(couponField) {
        if (couponField.length > 0) {
            this.couponField = couponField;
            this.form = couponField.closest('form');
            this.loader = this.form.find('[data-coupon-code-loader]');
            this.msg = $('[data-validation-msg]');

            this.loader.hide();
            
            this.setObservers();
        }
    }

    setObservers() {
        const self = this;

        self.couponField.on('focusout', function (e) {
            
            // get request vars
            const couponField = $(e.target);
            const couponCode = couponField.val();
            const nonce      = couponField.data('programCouponNonce');
            const pid        = couponField.data('programCouponProductId');

            if(couponCode){
                // show loader
                self.loader.show();

                $.ajax({
                    url: core.ajaxUrl,
                    data: {
                        action: 'mepr_validate_coupon',
                        code: couponCode,
                        prd_id: pid,
                        coupon_nonce: nonce
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (response) {
                        const resp = JSON.parse(response);
                        self.loader.hide();
    
                        self.enableForm();
    
                        if(!resp){
                            self.disableForm();
                            self.showError();
                        } else {
                            self.showValid();
                        }
                    }
                })
            }
            
        })

    }

    showError(){
        const self = this;

        self.msg.html('Not a valid coupon code. Please try again.');
        self.couponField.addClass('error');
        self.couponField.closest('.formControl').addClass('hasError');
    }

    showValid(){
        const self = this;

        self.msg.html('Coupon is valid!');
        self.couponField.removeClass('error');
        self.couponField.closest('.formControl').removeClass('hasError');
        self.loader.removeClass('fa-spinner fa-spin').addClass('fa-check').show();
    }

    disableForm(){
        const self = this;
        
        self.form.find('button[type="submit"]').attr('disabled', true);
    }

    enableForm(){
        const self = this;
        
        self.form.find('button[type="submit"]').attr('disabled', false);
    }

}