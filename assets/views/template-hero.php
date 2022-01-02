<?php $html = $title = $content = $direction = $link = '';

if( is_array( $hero ) )
{
  global $post;

  $direction = $hero['layout'];

  if( $hero['add_cta'] )
  {
    $link .= '<a href="'.$hero['cta_link'].'" class="btn ">'.$hero['cta_text'].'</a>';
  }

  $html .= '<div class="wrapper" data-hero data-hero-off="'.$hero['hero_turns_off'].'">';

    $html .= '<div class="hero-img" data-hero-img><img src="'.$hero['img']['url'].'" height="'.$hero['img']['height'].'" width="'.$hero['img']['width'].'" alt="" /></div>';

    if( $hero['heading'] != '' )
    {
      $html .= '<div class="table" data-hero-overlay>';

        $html .= '<div class="table-cell hero-inner">';

          $html .= '<div class="container small '.$direction.'">';

            $html .= '<div class="hero-content">'.$hero['heading'].$link.'</div>';

          $html .= '</div>';

        $html .= '</div>';

      $html .= '</div>';
    }

  $html .= '</div>';
}

echo $html;