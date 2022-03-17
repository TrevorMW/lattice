<?php $html = '';

if( is_array( $journey ) ){

    $html = '<h3>' . $journey['title'] . '</h3>
             <p>' . $journey['subtitle'] . '</p>
            <a href="' . get_permalink($journey['quiz_link']). '" class="btn btn-primary">' . $journey['cta_text'] . '</a>';
}

return $html;