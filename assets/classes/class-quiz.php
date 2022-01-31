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
    public $questionIndex;

    public function __construct(){
        $id = (int) get_option('page_for_quiz');

        if(is_int($id)){
            $this->postID = $id;
            parent::__construct($id);
        }

        $this->createIndex();
        $this->registerAjax();
    }

    public function registerAjax(){
        add_action( 'wp_ajax_nopriv_aenea_quiz', array($this, 'aeneaQuiz'));
        add_action( 'wp_ajax_aenea_quiz',        array($this, 'aeneaQuiz'));

        add_action( 'wp_ajax_nopriv_load_question_form', array($this, 'loadQuestionForm'));
        add_action( 'wp_ajax_load_question_form',        array($this, 'loadQuestionForm'));
    }

    public function getQuiz(){
        $html = '';

        if( is_user_logged_in() ){
            $html .= $this->getQuizQuestion();
        } else {
            $html .= $this->getRegisterForm();
        }

        return $html;
    }

    public function getQuizQuestion(){
        $firstQID = $this->quiz_questions[0]->ID;

        $q = new Question($this->quiz_questions[0]);
        $navData = $this->getQuizNavigationData($firstQID);

        return $q->getQuestionForm($firstQID, $navData);
    }

    public function getRegisterForm(){
        return Template_Helper::loadView('quiz-register', '/assets/views/pages/quiz/');
    }

    public function getResultsScreen(){
        $html = '';

        $data = array( 'quizdata' => 
            array(
                'results_title'      => 'For $89, you receive 30 days access to your customized curriculum and our full content library. For $229, receive a full years access!',
                'module_results'     => '',
                'intro_video'        => $this->quiz_results_page_intro_video,
                'intro_video_poster' => $this->quiz_results_page_intro_video_thumbnail,
                'membership_plans'   => $this->quiz_membership_plans
            )
        );

        $html .= Template_Helper::loadView('quiz-results', '/assets/views/pages/quiz/', $data);
        
        return $html;
    }

    public function createIndex(){
        if(count($this->quiz_questions) > 0){
            foreach($this->quiz_questions as $k => $qq){
                $qList[$k] = $qq->ID;
            }

            $this->questionIndex = $qList;
        }
    }

    public function getCurrentIndex($id, $arr){
        $idx = null;
        
        if($id !== null && is_array($arr)){
            $idx = array_search($id, $arr);
        }

        return $idx;
    }

    public function saveQuizQuestionData($id, $data){
        
    }

    public function getQuizNavigationData($currentQID, $canProceed = false){
        $data = array( 'next' => '', 'prev' => '', 'canProceed' => $canProceed);
        $qList = $this->questionIndex;

        if(count($qList) > 0){
            $currIdx = $this->getCurrentIndex($currentQID, $qList);
            $data['idx'] = $currIdx;

            if($currIdx !== false){
                if($currIdx <= 0){
                    //assume that we are at the first question
                    
                    if(!is_user_logged_in()){
                        $data['prev'] = 'register';
                    } else {
                        $data['prev'] = null;
                    }

                    $data['next'] = $qList[($currIdx + 1)];
                }

                // a question between the first and last question
                if($currIdx >= 1 && $currIdx < count($qList)){
                    $data['next'] = $qList[($currIdx + 1)];
                    $data['prev'] = $qList[($currIdx - 1)];
                }

                // Explicitly the last item
                if($currIdx === (count($qList) - 1)){
                    $data['next'] = 'payment';
                    $data['prev'] = $qList[($currIdx - 1)];
                }                
            }
        }

        return $data;
    }

    public function getQuizResults(){
        if ( ! is_admin() && isset( $_POST['lcrq'] ) ) {
            $return = aenea_return_quiz_results_data( $_POST['lcrq'] );
        }
    }

    public function aeneaQuiz() {
        $post = $_REQUEST;
        $resp = new Ajax_Response($post['action']);
        $qid = $post['current_id'];
        
        if(isset($post['question_' . $qid])){
            
            //$this->saveQuizQuestionData($qid, $post['question_' . $qid]);

            $resp->message = 'Data saved, loading next question';
            $resp->status = true;            
        } else {
            $resp->message = 'Please choose a quiz question';
        }

        $resp->data = $this->getQuizNavigationData($qid, $resp->status);

        echo $resp->encodeResponse();
      
        die(0);
    }

    public function loadQuestionForm(){
        $post      = $_REQUEST;
        $resp      = new Ajax_Response($post['action']);
        $direction = $post['direction'];

        if($direction === 'forward'){
            if(isset($post['next_question_id'])){
                
                if( $post['next_question_id'] === 'payment' ) {
                    $resp->data = array('msg' => 'Loading Results...');
                    $resp->html = $this->getResultsScreen();
                } else {
                    $id = (int) $post['next_question_id'];
    
                    $q = new Question($id);
                    $resp->html = $q->getQuestionForm($id, $this->getQuizNavigationData($id, true));
                }
            }
        }

        if($direction === 'back'){
            if(isset($post['next_question_id'])){
                if($post['prev_question_id'] === 'register'){
                    $resp->html = $this->getRegisterForm();
                } else {
                    $id = (int) $post['prev_question_id'];
        
                    $q = new Question($id);
                    
                    $resp->html = $q->getQuestionForm($id, $this->getQuizNavigationData($id, true));
                }
            }            
        }

        echo $resp->returnHtml();
      
        die(0);
    }
}