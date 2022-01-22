<?php $html = '';

if(is_object($member)){
 
    $html .= '<div class="gridItem teamMember teamMember-' . $member->post_name . '">';

    $html .= '<div class="teamMemberImage">' . get_the_post_thumbnail( $member->ID, 'medium') . '</div>';

    if($excerpt){
        $html .= '<div class="teamMemberExcerpt">' . get_excerpt_by_id( $member->ID) . '</div>';

        $html .= '<div class="teamMemberReadMore"><a href="' . get_permalink($member->ID) . '" class="btn btn-primary btn-small" >Read More</a></div>';
    } else {
        $html .= '<div class="teamMemberContent">' . apply_filters( 'the_content', $member->post_content ) . '</div>';
    }
    
    $html .= '</div>';
}

return $html;