<?php $html = '';

if( is_array($download) ){

    $html .= '<div>
                <a href="' . $download['filename'] . '" download="' . $download['nicename'] . '">
                    <img src="' . $download['imageUrl'] . '" alt="' . $download['imageAlt'] . '" title="' . $download['imageTitle'] . '" />
                </a>
              </div>';
}

return $html;