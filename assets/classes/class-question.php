<?php
/**
 * @package     Quiz
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
class Question extends WP_ACF_CPT
{   
    public $postID; 
    public $post;

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
            parent::__construct($id);
        } 

        if( $id instanceof WP_POST){
            $this->post   = $id;
            $this->postID = $this->post->ID;
            parent::__construct($this->post->ID);
        }
    }

    public function getQuestionForm($qid){
        $html = '';
        
        $selections = '';

        if($this->question_type['value'] == 'checkboxes'){
            $selections = $this->q_type_checkbox;
        }

        if($this->question_type['value'] == 'radios'){
            $selections = $this->q_type_radios;
        }

        if($this->question_type['value'] == 'text_field'){
            $selections = $this->q_type_text_field;
        }

        $data = array( 'question' => 
            array( 
                'q_idx'        => $qid,
                'q_next'       => '',
                'q_prev'       => 'register',
                'q_type'       => $this->question_type['value'], 
                'q_title'      => $this->post->post_title,
                'q_help_text'  => $this->post->post_content,
                'q_selections' => $selections,
            )
        );

        $html .= Template_Helper::loadView('quiz-question', '/assets/views/pages/quiz/', $data);
    
        return $html;
    }
}