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
        
        $deepdive = '';
        $links = $files = $posts = '';

        $deepdiveHtml .= '<div class="deepDiveMaterials">';

        if(is_array($this->deep_dive_downloadable_items) && count($this->deep_dive_downloadable_items) > 0){
            $downloadsContent .= '<div class="downloadsGrid">';
            $i = 0;

            foreach( $this->deep_dive_downloadable_items as $download ){ //var_dump($download);
                $downloadTitle = $download['dd_downloadable_item_title'];

                $downloadURL   = '';
                $downloadImage = '';
                
                if(!$download['dd_downloadable_item_file'] && $download['downloadable_item_thumbnail']){
                    $downloadURL   = $download['downloadable_item_thumbnail']['url'];
                    $downloadImage = $download['downloadable_item_thumbnail'];
                }

                if($download['dd_downloadable_item_file'] && !$download['downloadable_item_thumbnail']){
                    $downloadURL   = $download['dd_downloadable_item_file']['url'];
                    $downloadImage = get_template_directory_uri() . '/assets/static/img/no-image-found.jpg';
                }

                if($download['dd_downloadable_item_file'] && $download['downloadable_item_thumbnail']){
                    $downloadURL   = $download['dd_downloadable_item_file']['url'];
                    $downloadImage = $download['downloadable_item_thumbnail'];
                }
                
                $downloadData = array( 'download' => array(
                    'title'      => $downloadTitle,
                    'filename'   => $downloadURL,
                    'nicename'   => sanitize_title($downloadTitle),
                    'imageUrl'   => isset($downloadImage['url']) ? $downloadImage['url'] : get_template_directory_uri() . '/assets/static/img/no-image-found.jpg' ,
                    'imageAlt'   => isset($downloadImage['alt']) ? $downloadImage['alt'] : '',
                    'imageTitle' => isset($downloadImage['title']) ? $downloadImage['title'] : '',
                ));

                $downloadsContent .= '<div class="downloadCard">' . Template_Helper::loadView('download', '/assets/views/', $downloadData) . '</div>';
            }

            $downloadsContent .= '</div>';

            if($downloadsContent !== ''){
                $deepdiveHtml .= '<h4>Related Downloadables:</h4>' ;
                $deepdiveHtml .= '<div class="">' . $downloadsContent . '</div>' ;
                $deepdiveHtml .= '<br />';
            }
        }

        if(is_array($this->deep_dive_helpful_posts) && count($this->deep_dive_helpful_posts) > 0){
            foreach( $this->deep_dive_helpful_posts as $helpfulPost ){
                $data = array( 'post' => $helpfulPost['dd_helpful_post'][0]);
                $posts .= Template_Helper::loadView('post-card', '/assets/views/', $data);
            }

            if($posts !== ''){
                $deepdiveHtml .= '<h4>Helpful Posts:</h4>' ;
                $deepdiveHtml .= '<div class="postsPage curriculumPosts"><div class="blogPostGrid">' . $posts . '</div></div>' ;
                $deepdiveHtml .= '<br />';
            }
        }

        if(is_array($this->deep_dive_helpful_links) && count($this->deep_dive_helpful_links) > 0){
            foreach( $this->deep_dive_helpful_links as $link ){

                $data = array( 'link' => array(
                    'url' => $link['dd_link_url'],
                    'title' => $link['dd_link_text'],
                    'newTab' => $link['dd_link_new_tab'],
                    'classes' => ''
                ));
    
                $links .= '<li>' . Template_Helper::loadView('link','/assets/views/', $data) . '</li>';
            }

            if($links !== ''){
                $deepdiveHtml .= '<h4>Helpful Links:</h4>' ;
                $deepdiveHtml .= '<ul>' . $links . '</ul>' ;
            }
        }

        $deepdiveHtml .= '</div>';

        $data = array('tabs' => array());

        $data['tabs']['transcript'] = array(
            'title'   => 'Transcripts',
            'content' => $this->transcript
        );

        if(is_array($this->deep_dive_downloadable_items) || 
           is_array($this->deep_dive_helpful_posts) || 
           is_array($this->deep_dive_helpful_links)){
            $data['tabs']['deepdive'] = array(
                'title'   => 'Deep Dive',
                'content' => $deepdiveHtml 
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