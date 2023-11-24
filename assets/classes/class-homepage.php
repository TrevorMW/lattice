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
  public function __construct($id = null)
  {
    if(is_int($id)){
        $this->postID = $id;  
    }

    $this->registerAjax();
  }

  public function registerAjax(){
    add_action( 'wp_ajax_nopriv_newsletter_signup', array($this, 'newsletterSignup'));
    add_action( 'wp_ajax_newsletter_signup',        array($this, 'newsletterSignup'));
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

        $user = wp_get_current_user();

        if( in_array( Aenea_User::AENEA_ROLE_NAME, (array) $user->roles ) ){
          $data = array( 'hero' => array(
              'title'          => get_field('hero_title', $this->postID),
              'subtitle'       => get_field('hero_subtitle', $this->postID),
              'cta_text'       => 'View My Curriculum',
              'quiz_link'      => get_option('page_for_curriculum')
          ));
        }

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

        $user = wp_get_current_user();

        if( in_array( Aenea_User::AENEA_ROLE_NAME, (array) $user->roles ) ){
          $data = array( 'journey' => array(
              'title'     => get_field('journey_title',    $this->postID),
              'subtitle'  => get_field('journey_subtext', $this->postID),
              'cta_text'  => 'View My Curriculum',
              'quiz_link' => get_option('page_for_curriculum')
          ));
        }

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

  public function newsletterSignup(){
    $post = $_REQUEST;
    $resp = new Ajax_Response($post['action']);
    
    $email = filter_input(INPUT_POST, 'newsletter_email', FILTER_VALIDATE_EMAIL);

    if(!$email){
        $error = new WP_Error( 'invalidEmail', 'Your email address is not in a valid format.');
        $resp->message = $error->get_error_message();
    } else {
      $settings = new Global_Settings();
      $apiKey  = $settings->getGlobalSetting('mailchimp_api_secret');
      $result  = null;

      if($apiKey != null){
        $mchmp  = new MailChimp($apiKey);
        $listId = $settings->getGlobalSetting('mailchimp_signup_list_id');

        if($listId != null){
          $email = $post['newsletter_email'];
          $data = [
            'email_address' => $email,
            'status'        => 'pending',
            'merge_fields'   => array(
              'TYPE' => 0,
              'SOURCE' => 'Homepage Newsletter',
            )
          ];

          $endpoint = 'lists/' . $listId . '/members';

          $result = $mchmp->post($endpoint, $data);
          
          if($result['status'] === 'pending'){
            $resp->message = 'Success!';
            $resp->status = true;
          } else {
            $error = new WP_Error( 'memberExists', str_replace('Use PUT to insert or update list members.', '', $result['detail']));
            $resp->message = $error->get_error_message();
          }
        }

      } else {
        $error = new WP_Error( 'apiKey', 'Could not authenticate with email provider. Please check site settings.');
        $resp->message = $error->get_error_message();
      }

      if($result != null){

      } else {
        $error = new WP_Error( 'noResponse', 'No response from api call.');
        $resp->message = $error->get_error_message();
      }
      
    }

    echo $resp->encodeResponse();

    die(0);
  }
}
