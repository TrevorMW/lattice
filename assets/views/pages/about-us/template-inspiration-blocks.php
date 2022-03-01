<?php $html = '';

if( is_array($inspo) ){
    
    if($inspo['image']){

        $html .= '<div>';

        $html .= '<img src="' . $inspo['image']['url'] . '" alt="' . $inspo['image']['alt'] . '" title="' . $inspo['image']['title'] . '" />';
        
        $html .= '</div>';
    }

    if($inspo['content']){
        $html .= '<div>';

        $html .= apply_filters( 'the_content', $inspo['content'] );
        
        $html .= '</div>';
    }

}

return $html;