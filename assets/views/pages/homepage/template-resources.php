<?php $html = '';

if( is_array( $resources ) ){

    $html = '<h3>' . $resources['title'] . '</h3>';
    
    if( is_array( $resources['resources'] ) ){

        $html .= '<div class="container x-small">';

        $html .= '<div class="grid ctaGrid twoByTwo">';

        foreach( $resources['resources'] as $resource){
            $img = $resource['cta_image'];
            $html .= '<div class="gridItem resourceCTA">
                        <div class="resourceImage">
                        <img src="' . $img['sizes']['medium'] . '" alt="' . $img['alt'] . '" title="' . $img['title'] . '" height="' . $img['sizes']['medium-height'] . '" width="' . $img['sizes']['medium-width'] . '" /></div>
                        <div class="resourceTitle"><h4><a href="' . $resource['cta_link']['url'] . '" title="' . $resource['cta_link']['title'] . ' ">' . $resource['cta_text'] . '</a></h4></div>
                      </div>';
        }

        $html .= '</div>';
        $html .= '</div>';
    }
}

return $html;