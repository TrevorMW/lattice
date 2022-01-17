<?php $html = '';

if( is_array($podcast) ){
    $html .= '<div class="podcastPlayer"><iframe allowtransparency="true" height="150" width="100%" style="border: none;" scrolling="no" data-name="pb-iframe-player" src="' . $podcast['url'] . '"></iframe></div>';
}

return $html;