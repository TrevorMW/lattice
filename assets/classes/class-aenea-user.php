<?php 
/**
 * @package     Aenea_User
 * @author      Trevor Wagner
 * @copyright   Trevor Wagner
 * @license     GPL-2.0+
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Podcast
 */
class Aenea_User extends WP_ACF_CPT
{   
    public $user;
    public $quizModulesList;

    CONST FIELD_NAME = 'quiz_data';
    CONST AENEA_ROLE_NAME = 'aeneaUser';

    public function __construct($user = null){
        if(is_int($user)){
            $this->user = get_user_by('id', $user);
        } 

        if($user instanceof WP_User){
            $this->user = $user;
        }

        if($this->user instanceof WP_User){
            $this->quizModulesList = get_field(self::FIELD_NAME, 'user_' . $this->user->ID);
        }

        add_action( 'init', array($this, 'addAeneaUserRole') );
    }

    public function addAeneaUserRole(){
        add_role( self::AENEA_ROLE_NAME, 'Lattice Climbers Member', get_role( 'subscriber' )->capabilities );
    }

    public function saveOrUpdateQuizModulesList($data){
        $results = true;

        if( is_array($data) ){

            $formattedData = array();
            
            // convert new data to proper format
            if( is_array($data) ){
                foreach( $data as $k => $module ){
                    $formattedData[] = array( 'module_id' => (int) $module ); 
                }
            }

            $result = update_field( self::FIELD_NAME, $formattedData, 'user_' . $this->user->ID );  
            
            if(!$result){
                $results = false;
            }
        }

        return $results;
    }

    public function getModulesList(){
        return $this->quizModulesList;
    }

    public function isUserRegistered(){
        return in_array( self::AENEA_ROLE_NAME, (array) $this->user->roles );
    }
}