<?php $html = '';

if( is_array($lessonCard) ){

    $img = $lessonCard['image'];

    $class   = $lessonCard['status'] ? 'lessonCompleted' : '';
    $btnText = $lessonCard['status'] ? 'Rewatch Lesson' : 'Begin Lesson';

    $html .= '<div class="lessonCard ' . $class . '">';
    
    if( $img ){
        $html .= '<div class="lessonCardImage">' . $img . '</div>';
    } else {
        $html .= '<div class="lessonCardNoImage">
                    <a href="' . $lessonCard['permalink'] . '"><img src="' . get_template_directory_uri() . '/assets/static/img/logo.png" alt="lattice logo"/></a>
                </div>';
    }

    $html .= '<div class="lessonCardContent">';
    $html .= '<h2><a href="' . $lessonCard['permalink'] . '">' . $lessonCard['title'] . '</a></h2><br />';
    $html .= '<a href="' . $lessonCard['permalink'] . '" class="btn btn-secondary btn-small">' . $btnText . '</a>';
    $html .= '</div>';
    
    $html .= '</div>';
}

return $html;