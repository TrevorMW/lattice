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

        if(is_object($id)){
            $this->post = $id;
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
            $downloadsContent .= '<div class="downloadsGrid">';
            $i = 0;

            foreach( $this->downloads as $download ){
                $image = $download['download_preview_image'];
                
                if($image['url'] !== null){
                    $download = $download['download'];

                    $downloadData = array( 'download' => array(
                        'type'     => 'image',
                        'title'    => $download['title'],
                        'filename' => $download['url'],
                        'nicename' => $download['filename'],
                        'image'    => $image
                    ));

                    $i++;

                    $downloadsContent .= '<div class="downloadCard">' . Template_Helper::loadView('download', '/assets/views/', $downloadData) . '</div>';
                }
            }

            $downloadsContent .= '</div>';

            if($i !== count($this->downloads)){
                $downloadsContent .= '<br /><br /><h5>Additional Downloads:</h5>';
                $downloadsContent .= '<ul class="additionalDownloads">';
                
                foreach( $this->downloads as $download ){ 
                    $image = $download['download_preview_image'];
                    
                    if(!$image['url']){
                        $download = $download['download'];

                        $downloadData = array( 'download' => array(
                            'type'     => 'link',
                            'title'    => $download['title'],
                            'filename' => $download['url'],
                            'nicename' => $download['filename'],
                        ));

                        $downloadsContent .= '<li>' . Template_Helper::loadView('download', '/assets/views/', $downloadData) . '</li>';

                    }
                }

                $downloadsContent .= '</ul>';
            }
        }

        $data = array('tabs' => array());

        if(is_array($this->downloads) && count($this->downloads) > 0){
            $data['tabs']['downloads'] = array(
                'title'   => 'Downloads',
                'content' => $downloadsContent 
            );
        }

        $data['tabs']['transcript'] = array(
            'title'   => 'Transcripts',
            'content' => $this->transcript
        );

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

    public function getLessonCard($status = false){
        $html = '';

        $id = $this->post->ID;

        $data = array( 'lessonCard' => array(
            'id'    => $id,
            'title' => $this->post->post_title,
            'image' => get_the_post_thumbnail($id),
            'permalink' => get_permalink($id),
            'status' => $status
        )); 

        $html .= Template_Helper::loadView('lesson-card', '/assets/views/pages/library/', $data);

        return $html;
    }
}