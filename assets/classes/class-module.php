<?php
/**
 * @package     Module
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
class Module extends WP_ACF_CPT
{   
    public $postID; 
    public $post;

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
            $this->post = get_post($id);
            parent::__construct($id);
        } 

        if( $id instanceof WP_POST){
            $this->post   = $id;
            $this->postID = $this->post->ID;
            parent::__construct($this->post->ID);
        }
    }

    public static function getModuleAccordion($mid, $lessons, $usr, $idx = null, $membership){
        $html = '';
        $post = get_post($mid);

        if(count($lessons) > 0){
            $content = Module::getLessonHTML($lessons, $usr, $membership);
        } else {
            $btnTxt = $usr->isUserRegistered() ? 'Start Lesson <i class="fa fa-fw fa-play"></i> ' : '<i class="fa fa-fw fa-lock"></i> Unlock Module' ;
            $href   = $usr->isUserRegistered() ? get_permalink($mid) : get_permalink($membership) ; 
            $content = '<a href="' . $href . '" class="btn btn-secondary btn-small btn-disabled" type="submit">' . $btnTxt . '</a>';
        }
            
        $data = array( 'accordionItem' => array( 
            'id'      => $post->post_name,
            'title'   => $post->post_title,
            'content' => $content,
            'idx'     => $idx, 
            'tag'     => 'div',
            'class'   => $idx <= 1 ? 'active' : ''
        ));

        $html .= Template_Helper::loadView('accordion-item', '/assets/views/', $data);
    
        return $html;
    }

    public static function getCurriculumAccordion($module, $lessonHTML, $idx){
        $html = '';

        if( $module instanceof Module ){

            $class = $idx <= 0 ? 'active' : '' ;

            $data = array( 'module' => array( 
                'tag' => 'div',
                'class' => $class,
                'content' => $lessonHTML,
                'title' => $module->post->post_title,
                'id' => $module->post->ID,
                'status' => false,
            ));
            
            $data['module']['status'] = Module::isModuleFinished($module->post->ID);

            if($data['module']['status']){
                $data['module']['class'] .= ' done';
            }

            $html .= Template_Helper::loadView('curriculum-module', '/assets/views/pages/curriculum/', $data);
        }

        return $html;
    }

    public static function isModuleFinished($moduleID){
        $finished = false;

        $user            = new Aenea_User(wp_get_current_user());
        $courseId        = learndash_get_course_id($moduleID);
        $course_progress = learndash_user_get_course_progress( $user->user->ID, $courseId  );

        $moduleTopics =  $course_progress['topics'][$moduleID];

        if(is_array($moduleTopics) && count($moduleTopics) > 0){
            foreach($moduleTopics as $k => $topic){
                if($topic <= 0){
                    $finished = false;
                    break;
                } else {
                    $finished = true;
                }
            }
        }

        return $finished;
    }

    public static function getLessonHTML($lessons, $usr, $membership){
        $html = '';

        if( is_array($lessons) ){
            $i = 1;

            foreach( $lessons as $k => $lesson ){  
                $id   = (int) $lesson;
                $post = get_post($id);

                $btnTxt  = $usr->isUserRegistered() ? 'Start Lesson <i class="fa fa-fw fa-play"></i> ' : '<i class="fa fa-fw fa-lock"></i> Unlock Lesson' ;
                $href    = $usr->isUserRegistered() ? get_permalink($id) : get_permalink($membership) ; 
                $content = '<a href="' . $href . '" class="btn btn-secondary btn-small btn-disabled" type="submit" disabled>' . $btnTxt . '</a>';
                
                $data = array( 'accordionItem' => array( 
                    'id'      => $post->post_name,
                    'title'   => $post->post_title,
                    'content' => $content,
                    'idx'     => $i,
                    'tag'     => 'div',
                    'class'   => ''
                ));
        
                $html .= Template_Helper::loadView('accordion-item', '/assets/views/', $data);

                $i++;
            }
        }
        
        return $html;
    }

    public static function getResultsModulesHTML($modules, $usr, $membership){
        $html = '';
      
        if( is_array($modules) ){ 
            
            $i = 1;

            foreach( $modules as $k => $lessons ){
                $modID   = $k;
                
                if($modID){
                    $html .= Module::getModuleAccordion((int) $modID, $lessons, $usr, $i, $membership);
                }  

                $i++;    
            }
        }
    
        return $html;
    }
}