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
            
            $html .= '<div class="lessonCardGrid">';

            foreach( $loop->posts as $lesson ){
                $l = new Lesson($lesson);

                $html .= $l->getLessonCard();
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