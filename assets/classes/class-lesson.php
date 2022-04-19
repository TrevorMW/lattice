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
        
        $downloadsContent = $deepdive = '';
        
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

        if(is_array($this->deepdive) && count($this->deepdive) > 0){
            $links = $imgs = $files = $posts = '';

            foreach( $this->deepdive as $deepdive ){
                $type = $deepdive['dd_material_type'];
                
                if($type === 'link'){
                    
                    $data = array( 'link' => array(
                        'url' => $deepdive['dd_link_url'],
                        'title' => $deepdive['dd_link_title'],
                        'newTab' => true,
                        'classes' => ''
                    ));

                    $links .= '<li>' . Template_Helper::loadView('link','/assets/views/', $data) . '</li>';
                }

                if($type === 'file'){
                    //var_dump($deepdive);
                    $data = array( 'file-download' => array(
                        'url' => '',
                        'alt' => '',
                        'downloadNiceName' => '',
                        'classes' => '',
                        'url' => '',
                    ));

                    $files .= Template_Helper::loadView('link','/assets/views/', $data);
                }

                if($type === 'img'){

                    $data = array( 'image-download' => array(
                        '' => '',
                    ));
                }

                if($type === 'post'){
                    $data = array( 'post' => $deepdive['dd_blog_post']);

                    $posts .= Template_Helper::loadView('post-card', '/assets/views/', $data);
                }

                $deepdive .= '<div class="deepDiveMaterials">';

                $deepdive .= '<h4>Related Links:</h4>' ;
                $deepdive .= '<ul>' . $links . '</ul>' ;

                $deepdive .= '<br /><h4>Related Posts:</h4>' ;
                $deepdive .= '<div class="blogPostGrid">' . $posts . '</div>' ;

                $deepdive .= '<br /><h4>Related Files & Images:</h4>' ;
                $deepdive .= '<div class="">' . $files . '</div>' ;

                $deepdive .= '<div class="deepDiveMaterials">';
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

        if(is_array($this->deepdive) && count($this->deepdive) > 0){
            $data['tabs']['deepdive'] = array(
                'title'   => 'Deep Dive Materials',
                'content' => $deepdive 
            );
        }

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