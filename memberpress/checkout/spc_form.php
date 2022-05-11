<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<?php do_action('mepr-above-checkout-form', $product->ID); ?>

<div class="membershipCheckout">
    <div class="container flexed small">
        <div class="secondary">
            <?php if($mepr_options->enable_spc_invoice): ?>
                <div class="mepr-transaction-invoice-wrapper" style="padding-top:10px">
                    <span class="mepr-invoice-loader mepr-hidden">
                    <img src="<?php echo includes_url('js/thickbox/loadingAnimation.gif'); ?>" alt="<?php _e('Loading...', 'memberpress'); ?>" title="<?php _ex('Loading icon', 'ui', 'memberpress'); ?>" width="100" height="10" />
                    </span>
                    <div><?php MeprProductsHelper::display_spc_invoice( $product, $mepr_coupon_code ); ?></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="primary">
            <?php MeprView::render('/shared/has_errors', get_defined_vars()); ?>

            <form class="mepr-signup-form mepr-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'].'#mepr_jump'; ?>" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="mepr_process_signup_form" value="<?php echo isset($_GET['mepr_process_signup_form']) ? esc_attr($_GET['mepr_process_signup_form']) : 1 ?>" />
                <input type="hidden" name="mepr_product_id" value="<?php echo esc_attr($product->ID); ?>" />
                <input type="hidden" name="mepr_transaction_id" value="<?php echo isset($_GET['mepr_transaction_id']) ? esc_attr($_GET['mepr_transaction_id']) : ""; ?>" />
                
                <?php if(MeprUtils::is_user_logged_in()): ?>
                    <input type="hidden" name="logged_in_purchase" value="1" />
                    <input type="hidden" name="mepr_checkout_nonce" value="<?php echo esc_attr(wp_create_nonce('logged_in_purchase')); ?>">
                    <?php wp_referer_field(); ?>
                <?php endif; ?>

                <?php MeprHooks::do_action('mepr-before-coupon-field'); //Deprecated ?>
                <?php MeprHooks::do_action('mepr-checkout-before-coupon-field', $product->ID); ?>


                <?php if($payment_required || !empty($product->plan_code)): ?>
                <?php if($mepr_options->coupon_field_enabled): ?>
                <fieldset class="checkoutPromoCode">
                    <legend>Have a Coupon?</legend>
                    <div class="inlineForm">
                        <div class="formControl">
                            <div class="inlineInput">
                                <div class="mepr_coupon mepr_coupon_<?php echo $product->ID; ?>">
                                    <div class="mp-form-label">
                                        <label for="mepr_coupon_code<?php echo $unique_suffix; ?>"><?php _ex('Coupon Code:', 'ui', 'memberpress'); ?></label>
                                        <span class="cc-error"><?php _ex('Invalid Coupon', 'ui', 'memberpress'); ?></span>
                                        <span class="mepr-coupon-loader mepr-hidden">
                                            <i class="fa fa-fw fa-spin fa-spinner"></i>
                                        </span>
                                    </div>
                                    <input type="text" placeholder="Enter promo code to apply" id="mepr_coupon_code<?php echo $unique_suffix; ?>" class="mepr-form-input mepr-coupon-code" name="mepr_coupon_code" value="<?php echo (isset($mepr_coupon_code))?esc_attr(stripslashes($mepr_coupon_code)):''; ?>" data-prdid="<?php echo $product->ID; ?>" />
                                </div>
                            </div>
                            <div class="inlineSubmit">
                                <span for="mepr_coupon_code<?php echo $unique_suffix; ?>" class="btn btn-primary btn-fake-promo-apply">Apply Code</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php else: ?>
                    <input type="hidden" name="mepr_coupon_code" value="<?php echo (isset($mepr_coupon_code))?esc_attr(stripslashes($mepr_coupon_code)):''; ?>" />
                <?php endif; ?>
                
                <fieldset>
                    <legend>Customer Information</legend>
                <?php MeprHooks::do_action('mepr-checkout-before-name', $product->ID); ?>

                <?php if((!MeprUtils::is_user_logged_in() ||
                        (MeprUtils::is_user_logged_in() && $mepr_options->show_fields_logged_in_purchases)) &&
                        $mepr_options->show_fname_lname): ?>
                <div class="formControl half mepr_first_name">
                    <div class="mp-form-label">
                        <label for="user_first_name<?php echo $unique_suffix; ?>"><?php _ex('First Name:', 'ui', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
                        <span class="cc-error"><?php _ex('First Name Required', 'ui', 'memberpress'); ?></span>
                    </div>
                    <input type="text" name="user_first_name" id="user_first_name<?php echo $unique_suffix; ?>" class="mepr-form-input" value="<?php echo esc_attr($first_name_value); ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
                </div>
                <div class="formControl half last mepr_last_name">
                    <div class="mp-form-label">
                        <label for="user_last_name<?php echo $unique_suffix; ?>"><?php _ex('Last Name:', 'ui', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
                        <span class="cc-error"><?php _ex('Last Name Required', 'ui', 'memberpress'); ?></span>
                    </div>
                    <input type="text" name="user_last_name" id="user_last_name<?php echo $unique_suffix; ?>" class="mepr-form-input" value="<?php echo esc_attr($last_name_value); ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
                </div>
                <?php else: /* this is here to avoid validation issues */ ?>
                    <input type="hidden" name="user_first_name" value="<?php echo esc_attr($first_name_value); ?>" />
                    <input type="hidden" name="user_last_name" value="<?php echo esc_attr($last_name_value); ?>" />
                <?php endif; ?>

                <?php MeprHooks::do_action('mepr-checkout-before-custom-fields', $product->ID); ?>

                <?php if(!MeprUtils::is_user_logged_in() || (MeprUtils::is_user_logged_in() && $mepr_options->show_fields_logged_in_purchases)) {
                    MeprUsersHelper::render_custom_fields($product, 'signup', $unique_suffix);
                } ?>

                <?php MeprHooks::do_action('mepr-checkout-after-custom-fields', $product->ID); ?>

                <?php if(MeprUtils::is_user_logged_in()): ?>
                <input type="hidden" name="user_email" value="<?php echo esc_attr(stripslashes($mepr_current_user->user_email)); ?>" />
                <?php else: ?>
                <input type="hidden" class="mepr-geo-country" name="mepr-geo-country" value="" />

                <?php if(!$mepr_options->username_is_email): ?>
                    <div class="formControl half mepr_username">
                    <div class="mp-form-label">
                        <label for="user_login<?php echo $unique_suffix; ?>"><?php _ex('Username:*', 'ui', 'memberpress'); ?></label>
                        <span class="cc-error"><?php _ex('Invalid Username', 'ui', 'memberpress'); ?></span>
                    </div>
                    <input type="text" name="user_login" id="user_login<?php echo $unique_suffix; ?>" class="mepr-form-input" value="<?php echo (isset($user_login))?esc_attr(stripslashes($user_login)):''; ?>" required />
                    </div>
                <?php endif; ?>
                <div class="formControl mepr_email">
                    <div class="mp-form-label">
                    <label for="user_email<?php echo $unique_suffix; ?>"><?php _ex('Email:*', 'ui', 'memberpress'); ?></label>
                    <span class="cc-error"><?php _ex('Invalid Email', 'ui', 'memberpress'); ?></span>
                    </div>
                    <input type="email" name="user_email" id="user_email<?php echo $unique_suffix; ?>" class="mepr-form-input" value="<?php echo (isset($user_email))?esc_attr(stripslashes($user_email)):''; ?>" required />
                </div>
                <?php MeprHooks::do_action('mepr-after-email-field'); //Deprecated ?>
                <?php MeprHooks::do_action('mepr-checkout-after-email-field', $product->ID); ?>
                <?php if($mepr_options->disable_checkout_password_fields === false): ?>
                    <div class="formControl half mepr_password">
                        <div class="mp-form-label">
                            <label for="mepr_user_password<?php echo $unique_suffix; ?>"><?php _ex('Password:*', 'ui', 'memberpress'); ?></label>
                            <span class="cc-error"><?php _ex('Invalid Password', 'ui', 'memberpress'); ?></span>
                        </div>
                        <div class="mp-hide-pw">
                            <input type="password" name="mepr_user_password" id="mepr_user_password<?php echo $unique_suffix; ?>" class="mepr-form-input mepr-password" value="<?php echo (isset($mepr_user_password))?esc_attr(stripslashes($mepr_user_password)):''; ?>" required />
                            <button type="button" class="button mp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Show password', 'memberpress' ); ?>">
                            <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="formControl half last mepr_password_confirm">
                        <div class="mp-form-label">
                            <label for="mepr_user_password_confirm<?php echo $unique_suffix; ?>"><?php _ex('Password Confirm:*', 'ui', 'memberpress'); ?></label>
                            <span class="cc-error"><?php _ex('Password Confirmation Doesn\'t Match', 'ui', 'memberpress'); ?></span>
                        </div>
                        <div class="mp-hide-pw">
                            <input type="password" name="mepr_user_password_confirm" id="mepr_user_password_confirm<?php echo $unique_suffix; ?>" class="mepr-form-input mepr-password-confirm" value="<?php echo (isset($mepr_user_password_confirm))?esc_attr(stripslashes($mepr_user_password_confirm)):''; ?>" required />
                            <button type="button" class="button mp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Show password', 'memberpress' ); ?>">
                            <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </fieldset>
                    <?php MeprHooks::do_action('mepr-after-password-fields'); //Deprecated ?>
                    <?php MeprHooks::do_action('mepr-checkout-after-password-fields', $product->ID); ?>
                <?php endif; ?>
                <?php endif; ?>

                
                <fieldset>
                    <legend>Payment Information</legend>
                <div class="mepr-payment-methods-wrapper">
                    <?php if(sizeof($payment_methods) > 1): ?>
                        <h3><?php _ex('Select Payment Method', 'ui', 'memberpress'); ?></h3>
                    <?php endif; ?>
                    <div class="mepr-payment-methods-icons">
                        <?php echo MeprOptionsHelper::payment_methods_icons($payment_methods); ?>
                    </div>
                    <div class="mepr-payment-methods-radios<?php echo sizeof($payment_methods) === 1 ? ' mepr-hidden' : ''; ?>">
                        <?php echo MeprOptionsHelper::payment_methods_radios($payment_methods); ?>
                    </div>
                    <?php if(sizeof($payment_methods) > 1): ?>
                        <hr />
                    <?php endif; ?>
                    <?php echo MeprOptionsHelper::payment_methods_descriptions($payment_methods); ?>
                </div>
                <?php else: ?>
                    <input type="hidden" id="mepr_coupon_code-<?php echo $product->ID; ?>" name="mepr_coupon_code" value="<?php echo (isset($mepr_coupon_code))?esc_attr(stripslashes($mepr_coupon_code)):''; ?>" />
                <?php endif; ?>

                <?php if($mepr_options->enable_spc_invoice && $product->adjusted_price($mepr_coupon_code) <= 0.00 && false == ( isset($_GET['ca']) && class_exists('MPCA_Corporate_Account') )) { ?>
                    <div class="mepr-transaction-invoice-wrapper" style="padding-top:10px">
                        <span class="mepr-invoice-loader mepr-hidden">
                        <img src="<?php echo includes_url('js/thickbox/loadingAnimation.gif'); ?>" alt="<?php _e('Loading...', 'memberpress'); ?>" title="<?php _ex('Loading icon', 'ui', 'memberpress'); ?>" width="100" height="10" />
                        </span>
                        <div>  <!-- Transaction Invoice shows up here  --> </div>
                    </div>
                <?php } ?>

                <?php if($mepr_options->require_tos): ?>
                    <div class="mp-form-row mepr_tos">
                        <label for="mepr_agree_to_tos<?php echo $unique_suffix; ?>" class="mepr-checkbox-field mepr-form-input" required>
                        <input type="checkbox" name="mepr_agree_to_tos" id="mepr_agree_to_tos<?php echo $unique_suffix; ?>" <?php checked(isset($mepr_agree_to_tos)); ?> />
                        <a href="<?php echo stripslashes($mepr_options->tos_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo stripslashes($mepr_options->tos_title); ?></a>*
                        </label>
                    </div>
                <?php endif; ?>

                <?php if($mepr_options->require_privacy_policy && $privacy_page_link = MeprAppHelper::privacy_policy_page_link()): ?>
                    <div class="mp-form-row">
                        <label for="mepr_agree_to_privacy_policy<?php echo $unique_suffix; ?>" class="mepr-checkbox-field mepr-form-input" required>
                        <input type="checkbox" name="mepr_agree_to_privacy_policy" id="mepr_agree_to_privacy_policy<?php echo $unique_suffix; ?>" />
                        <?php echo preg_replace('/%(.*)%/', '<a href="' . $privacy_page_link . '" target="_blank">$1</a>', __($mepr_options->privacy_policy_title, 'memberpress')); ?>
                        </label>
                    </div>
                <?php endif; ?>

                <?php MeprHooks::do_action('mepr-user-signup-fields'); //Deprecated ?>
                <?php MeprHooks::do_action('mepr-checkout-before-submit', $product->ID); ?>
                </fieldset>
                <div class="mp-form-submit">
                <?php // This mepr_no_val needs to be hidden in order for this to work so we do it explicitly as a style ?>
                    <label for="mepr_no_val" class="mepr-visuallyhidden"><?php _ex('No val', 'ui', 'memberpress'); ?></label>
                    <input type="text" id="mepr_no_val" name="mepr_no_val" class="mepr-form-input mepr-visuallyhidden mepr_no_val mepr-hidden" autocomplete="off" />

                    <div class="submitButton">
                        <button type="submit" class="btn btn-primary btn-small mepr-submit"><?php echo stripslashes($product->signup_button_text); ?></button>
                    </div>
                    <img src="<?php echo admin_url('images/loading.gif'); ?>" alt="<?php _e('Loading...', 'memberpress'); ?>" style="display: none;" class="mepr-loading-gif" title="<?php _ex('Loading icon', 'ui', 'memberpress'); ?>" />
                </div>
            </form>
        </div>
    </div>     
</div>
