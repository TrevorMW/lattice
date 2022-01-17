<?php
/**
 * @package     Team_Member
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
class Team_Member
{   
    public $postID; 
    public $post;

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
        } else if ( $id instanceof Team_Member ){
            $this->post = $id;
        }
    }

    public static function getTeamMemberGridItem($post, $excerpt = false){
        $html = '';

        if($post instanceof WP_Post){
            $data = array( 'member' => $post, 'excerpt' => $excerpt );

            $html .= Template_Helper::loadView('team-member', '/assets/views/', $data);
        }

        return $html;
    }
}