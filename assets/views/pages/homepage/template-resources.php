<?php $html = '';

if( is_array( $resources ) ){

    $html = '<h3>' . $resources['title'] . '</h3>';
    
    if( is_array( $resources['resources'] ) ){

        $html .= '<div class="ctaGrid">';

        foreach( $resources['resources'] as $resource){
            $html .= '<div class="resourceCTA">
                        <div class="resourceImage">' . $resource['cta_image'] . '</div>
                        <div class="resourceTitle"><h4><a href="' . $resource['cta_link']['url'] . '" title="' . $resource['cta_link']['title'] . ' ">' . $resource['cta_text'] . '</a></h4></div>
                      </div>';
        }

        $html .= '</div>';
    }
}

return $html;