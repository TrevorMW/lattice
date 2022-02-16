<?php

class Global_Settings{

  public $postID;

  /**
   * 
   * __construct function.
   *
   * @access public
   * @param mixed $action (default: null)
   * @return void
   */
  public function __construct()
  {
    $id = (int) get_option('page_for_settings');
    
    if(is_int($id)){
        $this->postID = $id;
    }
  }

  public function getGlobalSetting($key){
    $data = null;

    if($key !== null){
        $data = get_field($key, $this->postID);
    }

    return $data;
  }

  public function getBasicModules(){
    return get_field('basic_quiz_modules', $this->postID);
  }
}
