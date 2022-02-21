<?php $html = '';

/**
 * 
 * array(
 *   'tab-id' => array(
 *      'title'   => 'tab title',
 *      'content' => 'tab content'
 *   )
 * )
 * 
 */

if( is_array($tabs) && count($tabs) >= 1 ){

    $html .= '<div class="curriculumTabs">';
    
    $html .= '<div class="tablist" role="tablist" aria-label="Entertainment">';
    
    $i = 0;
    foreach( $tabs as $trigger => $tab ){
        $class = $i === 0 ? 'active' : '';
        $html .= '<button data-tab-trigger="' . $trigger. '" 
                            class="' . $class . '"
                            type="button"
                            role="tab"
                            aria-selected="true"
                            aria-controls="' . $trigger. '"
                            id="' . $trigger. '"
                            tabindex="' . $i . '">' . $tab['title']. '</button>';

        $i++; 
    }

    $html .= '</div>';

    $j = 0;
    foreach( $tabs as $trigger => $tab ){
        $class = $j === 0 ? 'active' : '';

        $html .= '<div data-tab-content="' . $trigger. '" 
                        class="' . $class. '"
                        tabindex="0"
                        role="tabpanel"
                        id="' . $trigger. '"
                        aria-labelledby="' . $trigger. '">' . $tab['content'] . '</div>';

        $j++;
    }

    $html .= '</div>';
}

return $html;