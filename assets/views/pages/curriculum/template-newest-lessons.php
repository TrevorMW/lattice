<?php $html = '';

if( is_object($lesson) ){

    $html .= '<div class="lessonCard">';

    $html .= $lesson->post->post_title;

    $html .= '';

    $html .= '</div>';
}

return $html;