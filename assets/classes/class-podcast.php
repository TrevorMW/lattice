<?php
/**
 * @package     Podcast
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
class Podcast
{   
    public $postID; 

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
        }
    }

    public static function getPodcasts(){
        $html = '';
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type'      => 'podcast',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => 10,
            'paged'          => $paged
        );

        $loop = new WP_Query($args);

        if( $loop->have_posts() ) {
            $html .= '<div class="podcastList"><ul>';

            while( $loop->have_posts() ) {
                $loop->the_post();

                $data = array('podcast' => array(
                    'title' => $loop->post->post_title,
                    'url' => get_permalink($loop->post->ID)
                ));

                $html .= '<li>' . Template_Helper::loadView('podcast', '/assets/views/pages/podcast/', $data) . '</li>';
            }

            $html .= '</ul></div>';
            
            if($loop->max_num_pages > 1){
                $html .= '<div class="pagination paginationPodcasts">';

                $html .= build_pagination($loop, $paged);
                
                $html .= '</div>';
            }
        }

        return $html;
    }

    public function getPodcastPlayer(){
        $html = '';

        if(is_int($this->postID)){
            $data = array(
                'podcast' => array(
                    'url' => get_field('podcast_url', $this->postID),
                )
            );

            $html .= Template_Helper::loadView('podcast-player','/assets/views/pages/podcast/', $data);
        }

        return $html;
    }
}