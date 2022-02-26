<?php $html = '';

if(is_array($newsletter)){

    $html .= '<h4>' . $newsletter['title'] . '</h4>
              <p>' . $newsletter['subtitle'] . '</p>';

    $html .= '<div class="newsletterSignup">
                <form data-ajax-form data-action="newsletter_signup" class="inlineForm" data-no-progress>
                    <div class="formControl">
                        <div class="inlineInput">
                            <input type="email" placeholder="your.name@example.com" value="" name="newsletter_email" required/>
                        </div> 
                        <div class="inlineSubmit">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>  
                    </div>
                    <div data-form-msg></div>
                </form>
               
            </div>';

    if( is_array($newsletter['social_media'])){
        $html .= '<nav class="socialMedia"><ul>';

        foreach( $newsletter['social_media'] as $outlet ){
            $html .= '<li>
                        <a href="' . $outlet['social_url'] . '" title="' . $outlet['social_outlet'] . '" class="' . sanitize_title($outlet['social_outlet']). '" target="_blank" rel="noopener"></a>
                      </li>';

        }

        $html .= '</ul></nav>';
    }
}

return $html;

            

            