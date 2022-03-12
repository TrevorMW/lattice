<?php
/**
 * @package     About_Us
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
class Library extends WP_ACF_CPT
{   
    public $post; 

    public function __construct($id = null){
        if(is_int($id)){
            $this->post = get_post($id);
            parent::__construct($id);
        }

        if(is_object($id)){
            $this->post = $id;
            parent::__construct($id);
        }
    }

    public function getCompletionData(){
        $curr = new Curriculum();
        $user = wp_get_current_user();
       
        $progress = learndash_user_get_course_progress( $user->ID, 1683, true );

        return $curr->getCurriculumProgressBar($progress['summary']['completed'], $progress['summary']['total']);
    }

    public function getAllLessons(){
        $html = '';
        $query = '';

        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

        $postsperpage = get_field('lesson_pagination_count', $this->post->ID);
        
        $args = array(
            'post_type'      => 'sfwd-topic',
            'order'          => 'ASC',
            'posts_per_page' => $postsperpage,
            'paged'          => $paged
        );

        $loop = new WP_Query($args);

        if($loop->have_posts()){
            $courseId = learndash_get_course_id($loop->posts[0]->ID);
            $aeneaUser = new Aenea_User(wp_get_current_user());

            $progress = learndash_user_get_course_progress( $aeneaUser->user->ID, $courseId, false );
            $topicProgress = $progress['co'];

            $html .= '<div class="lessonCardGrid">';

            foreach( $loop->posts as $lesson ){
                $l = new Lesson($lesson);
                $completed = false;

                $completionData = $topicProgress['sfwd-topic:' . $lesson->ID];

                if($completionData){
                    $completed = true;
                }
                
                $html .= $l->getLessonCard($completed);
            }

            $html .= '</div>';
        }

        if($loop->max_num_pages > 1){
            $html .= '<div class="pagination paginationLessons">';

            $html .= build_pagination($loop, $paged);
            
            $html .= '</div>';
        }

        return $html;
    }
}