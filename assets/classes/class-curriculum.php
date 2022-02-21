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
                        'post_type' => 'sfwd-topic',
                        'posts_per_page' => '-1',
                        'meta_key' => 'lesson_id',
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
                    'tabs'     => $lesson->getLessonTabHTML(),
                    'progress' => $this->getCurriculumProgressBar(),
                    'video'    => $lesson->getLessonVideoHtml() 
                );
            }

            $resp->status = true;
        }

        echo $resp->encodeResponse();

        die(0);
    }

    public function markLessonDone($id){

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

    public function getCurriculumProgressBar(){
        $html    = '';
        $max     = $this->getTotalLessonCount();
        $state   = $this->getTotalFinishedLessonCount();
        $percent = number_format((( $state / $max ) * 100), 0);

        $data = array( 'progress' => array(
            'max'     => $max,
            'state'   => $state,
            'percent' => $percent . '%'
        ));

        $html .= Template_Helper::loadView('progress-bar', '/assets/views/', $data);

        return $html; 
    }
}