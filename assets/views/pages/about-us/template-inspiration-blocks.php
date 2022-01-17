<?php $html = '';

if( is_array($inspo) ){
    if($inspo['title']){
        $html .= '<h3>' . $inspo['title'] . '</h3>';
    }

    if($inspo['blocks']){
        $html .= '<div class="inspirationBlockGrid">';

        foreach( $inspo['blocks'] as $block ){

            $html .= '<div class="inspirationBlock">';
            $html .= '<h4>' . $block['inspiration_title'] . '</h4>';
            $html .= '<ul>';

            if(is_array($block['inspiration_blurps'])){
                foreach( $block['inspiration_blurps'] as $blurp){
                    $html .= '<li>' . $blurp['blurp'] . '</li>';
                }
            }

            $html .= '</ul>';
            $html .= '</div>';

        }
        
        $html .= '</div>';
    }

}

return $html;