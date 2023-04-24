<?php $html = $title = $content = $cta = $link = '';

if( is_array( $hero ) ){

    $html = '<h1>' . $hero['title'] . '</h1>
                ' . $hero['subtitle'] . '
                
                <a href="' . get_permalink($hero['quiz_link']). '" class="btn btn-secondary" data-start-quiz-modal="' . is_user_logged_in() . '">' . $hero['cta_text'] . '</a>';
}

return $html;