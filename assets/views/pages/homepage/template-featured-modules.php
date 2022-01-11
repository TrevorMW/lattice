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
                                <img src="" alt=""/>
                            </div>
                            <div class="moduleTitle">' . $module->post_title . '</div>  
                        </div>
                    </div>';
            
        }

        $html .= '</div>';
    }
}

return $html;
