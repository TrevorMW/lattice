<?php $html = '';

if( is_array($podcast) ){
    $html .= '<a href="' . $podcast['url'] . '" class="btn btn-primary btn-podcast">
                <span class="podcastBtnIcon">
                    <i class="fa fa-fw fa-microphone"></i>
                </span> 
                <span class="podcastBtnTitle">' . $podcast['title'] . '</span>
            </a>';
}

return $html;