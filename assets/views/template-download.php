<?php $html = '';

if( is_array($download) ){

    $html .= '<div>
                <a href="' . $download['filename'] . '" download="' . $download['nicename'] . '" title="Download ' . $download['nicename'] . '">
                    <img src="' . $download['imageUrl'] . '" alt="' . $download['imageAlt'] . '" title="' . $download['imageTitle'] . '" />
                    <div class="title">' . $download['title'] . '</div>
                    <span class="overlay"><i class="fa fa-fw fa-download"></i></span>
                </a>
              </div>';
}

return $html;