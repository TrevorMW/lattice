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
class Quiz extends WP_ACF_CPT
{   
    public $postID; 
    public $post;

    public function __construct($id = null){
        if(is_int($id)){
            $this->postID = $id;
            parent::__construct($id);
        }
    }

    public function getRegisterForm(){
        $html = '';
        $template = 'quiz-register';
        $data = array();
        
        if( is_user_logged_in() ){
            $firstQ = $this->quiz_questions[0];

            $i =0;
            foreach($this->quiz_questions as $questions ){
                $q = new Question($questions);

                $html .= $q->getQuestionForm($i);

                $i++;
            }
        } else {
            $html .= Template_Helper::loadView('quiz-register' , '/assets/views/pages/quiz/');
        }

        return $html;
    }
}