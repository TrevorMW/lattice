<?php
/**
 * @package     Curriculum
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
class Curriculum
{   
    const CURRICULUM_PROGRESS_FIELD_NAME = 'curriculum_completion_data';

    public $user;
    public $postID; 
    public $modulesList;
    public $completionData; 

    public function __construct(){
        $user = new Aenea_User(wp_get_current_user());

        if($user instanceof Aenea_User){
            $this->user = $user;
            $this->modulesList = $this->hydrateModulesList($user->quizModulesList);
            $this->completionData = $user->completionData;
        }

        $this->registerAjax();
    }

    public function registerAjax(){
        add_action( 'wp_ajax_nopriv_load_lesson', array($this, 'loadLesson'));
        add_action( 'wp_ajax_load_lesson',        array($this, 'loadLesson'));

        add_action( 'wp_ajax_nopriv_mark_done', array($this, 'markLessonDone'));
        add_action( 'wp_ajax_mark_done',        array($this, 'markLessonDone'));

        add_action( 'wp_ajax_nopriv_load_progress', array($this, 'loadProgressData'));
        add_action( 'wp_ajax_load_progress',        array($this, 'loadProgressData'));

        add_action( 'wp_ajax_nopriv_load_modules', array($this, 'loadModules'));
        add_action( 'wp_ajax_load_modules',        array($this, 'loadModules'));

    }

    public function getCurriculumModulesHTML(){
        $html = '';

        if( count($this->modulesList) > 0){
            
            $i = 0; 
            foreach( $this->modulesList as $moduleID => $lessonArray ){ 
                $module = new Module($moduleID);

                $html .= Module::getCurriculumAccordion($module, Lesson::getCurriculumLessonHTML($lessonArray, $this->completionData), $i);

                $i++;
            }
        }

        return $html;
    }   

    public function hydrateModulesList($currentModules){
        $modules = array();

        if(is_array($currentModules)){
            foreach ( $currentModules as $module ){
                $mid = $module['module_id'];
                $type = get_post_type($mid);

                if($type === 'sfwd-lessons'){
                    $args = array(
                        'post_type'      => 'sfwd-topic',
                        'posts_per_page' => '-1',
                        'meta_key'       => 'lesson_id',
                        'order'          => 'ASC',
                        'meta_value' => $mid,
                        'meta_compare' => '='
                    );
        
                    $loop = new WP_Query($args);
        
                    if($loop->have_posts()){
                        $modules[$mid] = array();
                        
                        foreach( $loop->posts as $post ){
                            $modules[$mid][] = $post->ID; 
                        }
                    }
                }

                if($type === 'sfwd-topic'){                    
                    $settings = learndash_get_setting($mid);
                    $moduleID = $settings['lesson'];

                    if(!array_key_exists($moduleID, $modules)){
                        $modules[$moduleID] = array();
                        $modules[$moduleID][] = $mid;
                    } else {
                        $modules[$moduleID][] = $mid;
                    }
                }
            }
        }

        return $modules;
    }

    public function getInitialLesson(){        
        return new Lesson($this->modulesList[array_key_first($this->modulesList)][0]);
    }

    public function loadLesson(){
        $post = $_REQUEST;
        $resp = new Ajax_Response($post['action']);
        
        $id = (int) $post['lesson_id'];

        if( is_int($id)){
            $lesson = new Lesson($id);

            if($lesson instanceof Lesson){
                $resp->data = array(
                    'id'       => $lesson->post->ID,
                    'title'    => $lesson->post->post_title,
                    'module'   => (int) get_post_meta($lesson->post->ID, 'lesson_id')[0],
                    'tabs'     => $lesson->getLessonTabHTML(),
                    'video'    => $lesson->getLessonVideoHtml() 
                );
            }

            $resp->status = true;
        }

        echo $resp->encodeResponse();

        die(0);
    }

    public function markLessonDone(){
        $post = $_REQUEST;
        $resp = new Ajax_Response($post['action']);
        
        $id    = (int) $post['lesson_id'];
        $modID = (int) $post['module_id'];

        if( is_int($id) ){
            $user = new Aenea_User(wp_get_current_user());
            
            if($user instanceof Aenea_User){
                $user->completionData[$id] = true;                
                $result = $user->saveCompletionData($user->completionData);
                $courseId = learndash_get_course_id($id);

                learndash_process_mark_complete($user->ID, $id, false, $courseId);

                if($result){
                    $resp->status = true;
                }
            }
        }

        if( is_int($modID) ){
            $resp->data['moduleFinished'] = Module::isModuleFinished($modID);
        } 

        echo $resp->encodeResponse();

        die(0);
    }

    public function getTotalFinishedLessonCount(){
        $count = 0;

        if( is_array($this->completionData) ){
            foreach( $this->completionData as $lessonID => $status ){
                if($status){
                    $count++;
                }
            }
        }

        return $count;
    }

    public function getTotalLessonCount(){
        $count = 0;

        if( is_array($this->completionData) ){
            foreach( $this->completionData as $lesson ){
                $count++;
            }
        }

        return $count;
    }

    public function getCurriculumProgressBar( $finished = null, $total = null ){
        $html    = '';
        $max     = $this->getTotalLessonCount();
        $state   = $this->getTotalFinishedLessonCount();

        if($finished !== null){
            $state = $finished;
        }

        if($total !== null){
            $max = $total;
        }

        $percent = number_format((( $state / $max ) * 100), 0);

        $data = array( 'progress' => array(
            'max'     => $max,
            'state'   => $state,
            'percent' => $percent . '%'
        ));

        $html .= Template_Helper::loadView('progress-bar', '/assets/views/', $data);

        return $html; 
    }

    public function loadProgressData(){
        $post = $_REQUEST;
        $resp = new Ajax_Response($post['action']);
        
        $resp->status = true;
        $resp->data = array(
            'progress' => $this->getCurriculumProgressBar()
        );

        echo $resp->encodeResponse();

        die(0);
    }

    public function loadModules(){
        $post = $_REQUEST;
        $resp = new Ajax_Response($post['action']);
        
        $resp->status = true;
        $resp->data = array(
            'modules' => $this->getCurriculumModulesHTML()
        );

        echo $resp->encodeResponse();

        die(0);
    }

    public function hasNewLessons(){
        $hasNew = false;

        $args = array(
            'post_type'      => 'sfwd-topic',
            'orderby'        => 'date',
            'posts_per_page' => '3',
            'date_query' => array(
                array(
                    'after' => '4 weeks ago'
                )
            )
        );
    
        $loop = new WP_Query($args);

        if($loop->have_posts()){
            $hasNew = true;
        }

        return $hasNew;
    }

    public function getNewestLessons(){
        $html = '';
        $lessons = null;

        $args = array(
            'post_type'      => 'sfwd-topic',
            'orderby'        => 'date',
            'posts_per_page' => '3',
            'date_query' => array(
                array(
                    'after' => '6 months ago'
                )
            )
        );
    
        $loop = new WP_Query($args);

        if($loop->have_posts()){
            $lessons = $loop->posts; 

            foreach( $lessons as $lesson ){
                $lessonData = new Lesson($lesson);
                $data       = array( 'lesson' => $lessonData );

                $html .= $lessonData->getLessonCard();
            }
        }

        return $html;
    }

    public static function parseModulesData(){
        $aeneaUser = new Aenea_User(wp_get_current_user());
        $moduleList = array();

        if($aeneaUser instanceof Aenea_User){
            $allModules = $aeneaUser->quizModulesList;
            $completionData = array();
        
            if( is_array($allModules) ){ 
                foreach( $allModules as $k => $module ){
                    $mid = $module['module_id'];

                    if($mid){
                        $type = get_post_type($mid);

                        if($type !== 'sfwd-topic' && !array_key_exists($mid, $moduleList)){
                            $moduleList[$mid] = array();
                        } 

                        if($type === 'sfwd-topic'){
                            $meta = get_post_meta($mid, 'lesson_id');
                            
                            if(is_array($meta) && count($meta) > 0){
                                $moduleList[$meta[0]][] = $mid;
                            }
                        }

                        if($type === 'sfwd-lessons'){
                            $args = array(
                                'post_type' => 'sfwd-topic',
                                'posts_per_page' => '-1',
                                'meta_key' => 'lesson_id',
                                'meta_value' => $mid,
                                'order'          => 'ASC',
                                'meta_compare' => '='
                            );
                
                            $loop = new WP_Query($args);
                
                            if($loop->have_posts()){
                                $moduleList[$mid] = array();

                                foreach( $loop->posts as $post ){
                                    $moduleList[$mid][] = $post->ID;

                                    $completionData[$post->ID] = false;
                                }
                            }
                        }
                    }
                }
            }

            // if(is_array($completionData) ){
            //     $aeneaUser->saveCompletionData($completionData); 
            // }
        }

        return $moduleList;
    }
}