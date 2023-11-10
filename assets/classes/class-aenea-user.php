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
    public $completionData;

    const CURRICULUM_PROGRESS_FIELD_NAME = 'curriculum_completion_data';
    const FIELD_NAME = 'quiz_data';
    const AENEA_ROLE_NAME = 'aeneaUser';
    const USER_DATA_EXPORT_FILENAME = 'lattice-user-data-export';

    public function __construct($user = null){

        if(is_int($user)){
            $this->user = get_user_by('id', $user);
        } 

        if($user instanceof WP_User){
            $this->user = $user;
        }

        if($this->user instanceof WP_User){
            $this->quizModulesList = get_field(self::FIELD_NAME,                                 'user_' . $this->user->ID);
            $this->completionData  = unserialize(get_field(self::CURRICULUM_PROGRESS_FIELD_NAME, 'user_' . $this->user->ID));
        }

        add_action( 'init', array($this, 'addAeneaUserRole') );

        add_action( 'wp_ajax_nopriv_generate_user_quiz_data', array($this, 'generateQuizExport'));
        add_action( 'wp_ajax_generate_user_quiz_data',        array($this, 'generateQuizExport'));

        add_action( 'wp_ajax_nopriv_get_quiz_export_files',   array($this, 'getQuizExportFiles'));
        add_action( 'wp_ajax_get_quiz_export_files', array($this, 'getQuizExportFiles'));
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

    public function getCompletionData(){
        return $this->completionData;
    }

    public function getModulesList(){
        return $this->quizModulesList;
    }

    public function isUserRegistered(){
        return in_array( self::AENEA_ROLE_NAME, (array) $this->user->roles );
    }

    public function saveCompletionData($data){
        $serializedData = serialize($data);
        return update_field(self::CURRICULUM_PROGRESS_FIELD_NAME, $serializedData, 'user_' . $this->user->ID);
    }

    public function generateQuizExport(){
        $resp = new Ajax_Response($_POST['action']);
        $fileType = $_POST['file_type'];

        if(!isset($_POST['file_type']) || $_POST['file_type'] === ''){
            $resp->status = false;
            $resp->message = 'Please choose an export file type!';

            echo $resp->encodeResponse();
            die(0);
        }

        $file = null;
        $folderPath = wp_upload_dir()['basedir'];
        $exportFolder = trailingslashit(  $folderPath . '/lattice-user-data-exports' );

        $args = array(
            'role'    => self::AENEA_ROLE_NAME,
            'orderby' => 'last_name',
            'order'   => 'ASC'
        );
        $users = get_users( $args );

        // create a new folder 
        if(!is_dir($exportFolder)){
            $result = wp_mkdir_p($exportFolder);
        }
        if($fileType == 'CSV'){
            $file = fopen($exportFolder . self::USER_DATA_EXPORT_FILENAME . '.csv', "w");
        }

        if($fileType == 'XLS'){
            $file = fopen($exportFolder. self::USER_DATA_EXPORT_FILENAME . '.xslx', "w");
        }
        
        if(count($users) > 0){
            if($fileType === 'CSV'){
                $headers = [
                    'Email',
                    'First Name',
                    'Last Name'
                ];
            }

            foreach($users as $user){
                $id = 'user_' . $user->ID;
                $quizData = get_field('quiz_answers', $id);

                if($fileType === 'CSV'){

                    if($quizData){
                        foreach($quizData as $k => $q){
                            $headers[] = $q['quiz_question'];
                        }

                        $headers = array_unique($headers);
                    }
                }
            }

            // WRITE HEADERS
            fputcsv($file, $headers);

            foreach($users as $user){
                $id = 'user_' . $user->ID;
                $data = array(
                    'Email' => $user->user_email,
                    'First Name' => $user->first_name,
                    'Last Name' => $user->last_name
                );
                $quizData = get_field('quiz_answers', $id);

                if($fileType === 'CSV'){

                    if($quizData){
                        foreach($quizData as $k => $q){
                            
                            $answerData = [];

                            foreach($q['quiz_question_answers'] as $k => $answer){
                                $answerData[] = $answer['quiz_answer'];
                            }
                            
                            $data[$q['quiz_question']] = implode(',', $answerData);
                        }
                    }

                    fputcsv($file, $data);
                }
            }

            $resp->status = true;
            $resp->message = 'CSV File generated';
            $resp->callback = 'core:files:load';
        }

        echo $resp->encodeResponse();
        die(0);
    }

    public function getQuizExportFiles(){
        $resp     = new Ajax_Response($_POST['action']);

        $folderPath   = wp_upload_dir()['basedir'];
        $exportFolder = trailingslashit(  $folderPath . '/lattice-user-data-exports' );
        $files        = array_slice(scandir($exportFolder), 2);

        if(count($files) < 0){
            // do stuff
            $resp->status = false;
            $resp->message = 'No Generated Files present!';
            
        } else {
            $fileHTML = '<ul>';
            foreach($files as $file){ 
                $fullPath = trailingslashit(  wp_upload_dir()['baseurl'] . '/lattice-user-data-exports' ) . $file;
                $fileHTML .= '<li><i class="fa fa-fw fa-download"></i>';
                $fileHTML .= '<a href="' . $fullPath . '" download>' . $file . '</a>';
                $fileHTML .= '</li>';
            }

            $fileHTML .= '</ul>';

            $resp->data = array('html' => $fileHTML);
            $resp->status = true;
        }

        echo $resp->encodeResponse();
        die(0);
    }
}