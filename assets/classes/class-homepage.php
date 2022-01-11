<?php

class Homepage
{
  public $postID;

  /**
   * 
   * __construct function.
   *
   * @access public
   * @param mixed $action (default: null)
   * @return void
   */
  public function __construct($id)
  {
    if(is_int($id)){
        $this->postID = $id;
    }
  }

  public function getHomepageHero(){
    $html     = null;
    $settings = new Global_Settings();

    if(is_int($this->postID)){
        $data = array( 'hero' => array(
            'title'          => get_field('hero_title', $this->postID),
            'subtitle'       => get_field('hero_subtitle', $this->postID),
            'cta_text'       => get_field('hero_cta_text', $this->postID),
            'quiz_link'      => $settings->getGlobalSetting('quiz_page_id')
        ));

        $html = Template_Helper::loadView('hero', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

  public function getHomepageTimeline(){
    $html = null;

    if(is_int($this->postID)){
        $data = array( 'timeline' => array(
            'title'    => get_field('timeline_title',    $this->postID),
            'subtitle' => get_field('timeline_subtitle', $this->postID),
            'steps'    => get_field('timeline_steps',    $this->postID)
        ));

        $html = Template_Helper::loadView('timeline', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

  public function getHomepageFeaturedModules(){
    $html = null;

    if(is_int($this->postID)){
        $data = array( 'modules' => array(
            'title'    => get_field('modules_title',    $this->postID),
            'subtitle' => get_field('modules_subtitle', $this->postID),
            'modules'  => get_field('modules',         $this->postID)
        ));

        $html = Template_Helper::loadView('featured-modules', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

  public function getHomepageJourney(){
    $html = null;
    $settings = new Global_Settings();

    if(is_int($this->postID)){
        $data = array( 'journey' => array(
            'title'     => get_field('journey_title',    $this->postID),
            'subtitle'  => get_field('journey_subtext', $this->postID),
            'cta_text'  => get_field('journey_cta_text', $this->postID),
            'quiz_link' => $settings->getGlobalSetting('quiz_page_id')
        ));

        $html = Template_Helper::loadView('journey', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

  public function getHomepageResources(){
    $html = null;

    if(is_int($this->postID)){
        $data = array( 'resources' => array(
            'title'     => get_field('resources_title',      $this->postID),
            'resources' => get_field('resources_cta_blocks', $this->postID)
        ));

        $html = Template_Helper::loadView('resources', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

  public function getHomepageNewsletterSignup(){
    $html = null;
    $settings = new Global_Settings();

    if(is_int($this->postID)){
        $data = array( 'newsletter' => array(
            'title'        => get_field('newsletter_signup_title',   $this->postID),
            'subtitle'     => get_field('newsletter_signup_subtext', $this->postID),
            'social_media' => $settings->getGlobalSetting('social_media')
        ));

        $html = Template_Helper::loadView('newsletter-signup', '/assets/views/pages/homepage/', $data);
    } 

    return $html;
  }

}
