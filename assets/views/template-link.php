<?php $html = '';

if( is_array($link) && $link['url'] !== null && $link['title'] !== null ){

    $target = $link['target'] ? 'target="_blank"' : '' ;

    $html .= '<a href="' . $link['url'] . '" class="' . $link['classes'] . '" ' . $target . '>' . $link['title'] . '</a>';
}

return $html;