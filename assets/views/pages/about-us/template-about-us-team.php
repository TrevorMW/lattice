<?php $html = '';

if( is_array($team) ){

    if($team['image']){

        $html .= '<div>';

        $html .= '<div class="imgWithCaption">
                    <figure>
                        <img src="' . $team['image']['url'] . '" alt="' . $team['image']['alt'] . '" title="' . $team['image']['title'] . '" />
                        <figcaption>' . $team['image']['caption'] . '</figcaption>
                    </figure>
                  </div>';
        $html .= '</div>';
    }

    if($team['content']){
        $html .= '<div>';

        $html .= apply_filters( 'the_content', $team['content'] );
        
        $html .= '</div>';
    }
}

return $html;