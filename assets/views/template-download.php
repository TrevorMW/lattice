<?php $html = '';

if( is_array($download) ){

    if( $download['type'] === 'link' ){
        $html .= '<a href="' . $download['filename'] . '" download="' . $download['nicename'] . '"><i class="fa fa-fw fa-download"></i>&nbsp;' . $download['title'] . '</a>';
    }

    if( $download['type'] === 'image' ){
        $html .= '<a href="' . $download['filename'] . '" download="' . $download['nicename'] . '">' . $download['image'] . '</a>';
    }
}

return $html;