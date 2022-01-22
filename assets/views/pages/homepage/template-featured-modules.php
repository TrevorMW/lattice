<?php $html = '';

if(is_array($modules)){
    $html = '<h3>' . $modules['title'] . '</h3>
             <p>' . $modules['subtitle'] . '</p>';

    if( is_array($modules['modules']) ){
        $html .= '<div class="modulesList">';

        foreach( $modules['modules'] as $module ){
            
            $html .= '<div class="latticeModule">
                        <div class="latticeModuleInner">
                            <div class="moduleImg">
                                ' . get_the_post_thumbnail( $module->ID, 'medium'). '
                            </div>
                            <div class="moduleTitle"><h4>' . $module->post_title . '</h4></div>  
                        </div>
                    </div>';
            
        }

        $html .= '</div>';
    }
}

return $html;
