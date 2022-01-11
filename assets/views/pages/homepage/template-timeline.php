<?php $html = '';

if( is_array( $timeline ) ){
    
    if($timeline['title'] !== null){
        $html .= '<h2>' . $timeline['title'] . '</h2>';
    }

    if(count($timeline['steps']) > 1){
        $html .= '<div class="timeline">';

        $i = 0;
        foreach( $timeline['steps'] as $step ){
            $alt = $i % 2 !== 0 ? 'evenStep' : 'oddStep';
            
            $html .= '<div class="timelineStep ' . $alt . '">
                        <div class="timelineStepContent">' . $step['timeline_step'] . '</div>
                        <div class="timelineStepSpacer"></div>
                      </div>';

            $i++;
        }

        $html .= '</div>';
    }
                                    
    if($timeline['title'] !== null){
        $html .= '<h2>' . $timeline['subtitle'] . '</h2>';
    }

    $html .=        '</section>
                </div>
            </div>';
}


/**
 * 

<div class="timeline">
  <div class="container left">
    <p>
      <i class="fa fa-code-fork" aria-hidden="true"></i>
    <div class="content">
      <h2>Git Basics</h2>
      <p>Visit <a href="https://learngitbranching.js.org/">this site</a> to learn about Git and become comfortable with basic Git practices</p>
    </div>
  </div>
  <div class="container right">
    <div class="content">
      <h2>Puppet Language Basics</h2>
      <p><a href="https://puppet.com/learning-training/kits/puppet-language-basics/">This self-paced course</a> will teach you the basics of understanding and writing Puppet code in less than thirty minutes.</p>
    </div>
  </div>
    <div class="container left">
    <div class="content">
      <h2>Puppet Practice Labs</h2>
      <p>Now you are ready to write some Puppet code in an <a href="https://learn.puppet.com/practicelabcatalog">interactive, browser based environment</a>.</p>
    </div>
  </div>
    <div class="container right">
    <div class="content">
      <h2>PE101: Deploy & Discover</h2>
      <p>At this point you are ready to take the in-person training and implement Puppet in your own environment.<p><i>Coming soon!</i></p></p>
    </div>
  </div>
  <div class="container left">
    <div class="content">
      <h2>PE201: Design & Manage</h2>
      <p>Already have Puppet implemented? Learn best practices for designing and managing your environment.<p><i>Coming soon!</i></p>
    </div>
  </div>
    <div class="container right">
    <div class="content">
      <h2>Keep going!</h2>
      <p>The journey never ends. <a href="http://learn.puppet.com">Here are some resources</a> to keep you on your learning path.</p>
    </div>
  </div>
</div>
 */

return $html;

