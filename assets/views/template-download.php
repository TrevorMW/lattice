<?php $html = '';

if( is_array($download) ){

    if( $download['type'] === 'link' ){
        $html .= '<a href="' . $download['filename'] . '" download="' . $download['nicename'] . '"><i class="fa fa-fw fa-download"></i>&nbsp;' . $download['title'] . '</a>';
    }

    if( $download['type'] === 'image' ){
        $html .= '<div><a href="' . $download['filename'] . '" download="' . $download['nicename'] . '"><img src="' . $download['image']['url'] . '" alt="' . $download['image']['alt'] . '" title="' . $download['image']['title'] . '" /></a></div>';
    }
}

return $html;