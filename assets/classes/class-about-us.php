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
class About_Us extends WP_ACF_CPT
{   
    public $postID; 

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
            parent::__construct($id);
        }
    }

    public function getInspirationContent(){
        $html = '';

        $data = array( 'inspo' => array(
            'content' => $this->inspiration_content,
            'image'   => $this->inspiration_image
        ));

        $html .= Template_Helper::loadView('inspiration-blocks', '/assets/views/pages/about-us/', $data);

        return $html;
    }

    public function getTeamMemberGrid(){
        $html = '';

        $data = array( 'team' => array(
            'image'   => $this->team_member_image,
            'content' => $this->team_member_content
        ));
        $html .= Template_Helper::loadView('about-us-team', '/assets/views/pages/about-us/', $data);

        return $html;
    }
}