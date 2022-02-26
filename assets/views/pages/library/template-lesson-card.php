<?php $html = '';

if( is_array($lessonCard) ){

    $img = $lessonCard['image'];

    $html .= '<div class="lessonCard">';
    
    if( $img ){
        $html .= '<div class="lessonCardImage">' . $img . '</div>';
    } else {
        $html .= '<div class="lessonCardNoImage">
                    <img src="' . get_template_directory_uri() . '/assets/static/img/logo.png" alt="lattice logo"/>
                </div>';
    }

    $html .= '<div class="lessonCardContent">';
    $html .= '<h2>' . $lessonCard['title'] . '</h2><br />';
    $html .= '<a href="' . $lessonCard['permalink'] . '" class="btn btn-secondary btn-small">Begin Lesson</a>';
    $html .= '</div>';
    
    $html .= '</div>';
}

return $html;