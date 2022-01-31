<?php $html = '';

if(is_array($quizdata)){
    $plans = $quizdata['membership_plans'];

    foreach( $plans as $planID ){
        $post = get_post($planID);

        $html .= '<div data-tab-trigger="' . $planID . '">Monthly</div>';
    }

    foreach( $plans as $planID ){
        $html .= '<div data-tab-content="' . $planID . '">' . do_shortcode('[mepr-membership-registration-form id="' . $planID . '"]') . '</div>';
    }
}

return $html;