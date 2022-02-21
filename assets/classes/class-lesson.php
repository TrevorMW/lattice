<?php
/**
 * @package     Lesson
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
class Lesson extends WP_ACF_CPT {  

    public $post; 

    public function __construct($id = null){
        if(is_int($id)){
            $this->post = get_post($id);
            parent::__construct($id);
        }
    }

    public function getFirstLesson(){
        return $this;
    }

    public function getVideoID(){
        return explode('https://vimeo.com/', $this->vimeo_video)[1];
    }

    public function getLessonVideoHtml(){
        $html = '';

        $id = $this->getVideoID();

        $data = array( 'video' => array(
            'id' => $id
        ));

        $html .= Template_Helper::loadView('video-player', '/assets/views/pages/curriculum/', $data);

        return $html;
    }

    public function getLessonTabHTML(){
        $html = '';
        
        $downloadsContent = '';

        if(is_array($this->downloads) && count($this->downloads) > 0){
            $downloadsContent .= '<ul>';
            
            foreach( $this->downloads as $download ){
                $download = $download['download'];

                $downloadData = array( 'download' => array(
                    'type'     => 'link',
                    'title'    => $download['title'],
                    'filename' => $download['url'],
                    'nicename' => $download['filename']
                ));
                
                $downloadsContent .= '<li>' . Template_Helper::loadView('download', '/assets/views/', $downloadData) . '</li>';
            }

            $downloadsContent .= '</ul>';
        }

        $data = array('tabs' => array(
            'downloads' => array(
                'title'   => 'Downloads',
                'content' => $downloadsContent 
            ),
            'transcript' => array(
                'title'   => 'Transcripts',
                'content' => $this->transcript
            )
        ));

        $html .= Template_Helper::loadView('tabs','/assets/views/', $data);

        return $html;
    }

    public static function getCurriculumLessonHTML($lessons, $completionData){
        $html = '';

        if( is_array($lessons) ){

            $html .= '<ul>';

            foreach($lessons as $lesson){
                $l = new Lesson($lesson);

                $status = $completionData[$lesson];

                $data = array( 'lesson' => array(
                    'id' => $l->post->ID,
                    'title' => $l->post->post_title,
                    'completed' => $status,
                    'slug' => $l->post->post_name,
                ));

                $html .= Template_Helper::loadView('curriculum-lesson', '/assets/views/pages/curriculum/', $data);
            }

            $html .= '</ul>';
        }
        
        return $html;
    }
}