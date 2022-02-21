<?php $html = '';

if( is_array($video) ){

    $html .= '<div class="lessonPlayer" data-lesson-player>
                <iframe src="https://player.vimeo.com/video/' . $video['id']. '?loop=0&amp;title=0&amp;byline=0&amp;muted=0&amp;color&amp;autopause=0&amp;autoplay=0" frameborder="0" allowfullscreen="1" allow="encrypted-media;"></iframe>
              </div>';

}

return $html;
