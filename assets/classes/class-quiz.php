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

    //////////////////////////////////////////////////////////////// 
    //////////////// SETUP /////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

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


    //////////////////////////////////////////////////////////////// 
    //////////////// Utilities ///////////////////////////////////// 
    ////////////////////////////////////////////////////////////////

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

    public function getQuizNavigationData($currentQID, $canProceed = false){
        $data = array( 'next' => '', 'prev' => '', 'canProceed' => $canProceed, 'msg' => 'Loading Question...');
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
                    $data['msg']  = 'Loading Results...';
                    $data['prev'] = $qList[($currIdx - 1)];
                }                
            }
        }

        return $data;
    } 

    public function maybeArray($data = null){
        $dataArray = array();

        if( is_array($data)){
            $dataArray = $this->simplifyQuizDataArray($data);
        }

        return $dataArray;
    }

    public function simplifyQuizDataArray($data){
        $oneDimArray = array();

        if( is_array($data) ){
            foreach($data as $val){
                $oneDimArray[] = $val['module_id'];
            }
        }

        return $oneDimArray;
    }

    
    //////////////////////////////////////////////////////////////// 
    //////////////// VIEWS /////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    public function getQuiz(){
        $html = '';

        if( is_user_logged_in() ){
            $html .= $this->getQuizQuestion();
        } else {
            $html .= $this->getRegisterForm();
        }

        return $html;
    }

    public function getRegisterForm(){
        return Template_Helper::loadView('quiz-register', '/assets/views/pages/quiz/');
    }

    public function resetQuizData(){
        $aeneaUser = new Aenea_User(wp_get_current_user());

        $aeneaUser->saveOrUpdateQuizModulesList( array() );
    }

    public function getQuizQuestion(){
        $this->resetQuizData();
        $firstQID = $this->quiz_questions[0]->ID;

        $q = new Question($this->quiz_questions[0]);
        $navData = $this->getQuizNavigationData($firstQID);
        

        return $q->getQuestionForm($firstQID, $navData);
    }

    public function getResultsScreen(){
        $html = '';

        $data = array( 'quizdata' => 
            array(
                'results_title'      => 'Your Results',
                'module_html'        => $this->getQuizModuleResultsHTML($this->quiz_membership_plans[0]),
                'intro_video'        => $this->quiz_results_page_intro_video_id,
                'intro_video_poster' => $this->quiz_results_page_intro_video_thumbnail,
                'membership_plan'    => get_post($this->quiz_membership_plans[0])
            )
        );

        $html .= Template_Helper::loadView('quiz-results', '/assets/views/pages/quiz/', $data);
        
        return $html;
    }

    public function getQuizModuleResultsHTML($membership){
        $modules = array();

        $aeneaUser = new Aenea_User(wp_get_current_user());

        if($aeneaUser instanceof Aenea_User){
            $allModules = $aeneaUser->quizModulesList;
            $moduleList = array();
            $completionData = array();
        
            if( is_array($allModules) ){ 
                foreach( $allModules as $k => $module ){
                    $mid = $module['module_id'];

                    if($mid){
                        $type = get_post_type($mid);

                        if($type !== 'sfwd-topic' && !array_key_exists($mid, $moduleList)){
                            $moduleList[$mid] = array();
                        } 

                        if($type === 'sfwd-topic'){
                            $meta = get_post_meta($mid, 'lesson_id');
                            
                            if(is_array($meta) && count($meta) > 0){
                                $moduleList[$meta[0]][] = $mid;
                            }
                        }

                        if($type === 'sfwd-lessons'){
                            $args = array(
                                'post_type' => 'sfwd-topic',
                                'posts_per_page' => '-1',
                                'meta_key' => 'lesson_id',
                                'meta_value' => $mid,
                                'order'          => 'ASC',
                                'meta_compare' => '='
                            );
                
                            $loop = new WP_Query($args);
                
                            if($loop->have_posts()){
                                $moduleList[$mid] = array();

                                foreach( $loop->posts as $post ){
                                    $moduleList[$mid][] = $post->ID;

                                    $completionData[$post->ID] = false;
                                }
                            }
                        }
                    }
                }
            }

            if( is_array($completionData) ){
                $aeneaUser->saveCompletionData($completionData); 
            }

            $modules = Module::getResultsModulesHTML($moduleList, $aeneaUser, $membership);
        }

        return $modules;
    }


    //////////////////////////////////////////////////////////////// 
    //////////////// AJAX OPERATIONS /////////////////////////////// 
    ////////////////////////////////////////////////////////////////

    public function aeneaQuiz() {
        $proceed   = true;
        $post      = $_REQUEST;
        $resp      = new Ajax_Response($post['action']);
        $subaction = $post['subaction'];

        $pass     = $post['password'];
        $email    = $post['email'];
        
        // handle registrations of users. Set them as subscriber, they will become aenea_user when they start a membership
        if( $subaction === 'register' ){
            
            // if passwords dont match, throw an error.
            if( $post['password'] !== $post['confirm'] ){
                $error         = new WP_Error( 'nonmatchingPass', 'Your passwords do not match.');
                $proceed       = false;
                $resp->message = $error->get_error_message();
            }

            // Check email is proper.
            if($proceed){
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

                if(!$email){
                    $error         = new WP_Error( 'invalidEmail', 'Your email address is not in a valid format.');
                    $proceed       = false;
                    $resp->message = $error->get_error_message();
                }
            }

            $user = get_user_by('email', $email);

            if($user instanceof WP_User){
                $proceed       = false;
                $resp->message = 'Email address "' . $email. '" is already in use.';
            }

            // Try and create new user.
            if($proceed){
                $newUserID = wp_create_user( $email, $pass, $email );

                if(!$newUserID instanceof WP_User){   
                    do_action( 'add_user_role', $newUserID, Aenea_User::AENEA_ROLE_NAME );
                    
                    $hasCoupon = $post['coupon'] && $post['coupon'] !== '' ? true : false ;

                    $acfUserID = 'user_' . $newUserID;

                    update_user_meta( $newUserID, "first_name",  $post['first_name']);
                    update_user_meta( $newUserID, "last_name",   $post['last_name']);

                    update_field( "city", $post['city'],                    $acfUserID);
                    update_field( "state", $post['state'],                  $acfUserID);
                    update_field( "high_school", $post['high_school'],      $acfUserID);
                    update_field( "user_signed_up_with_coupon", $hasCoupon, $acfUserID);

                    update_field("user_signed_up_with_coupon", $hasCoupon, $acfUserID);
                    
                    if($hasCoupon){
                        update_field("user_course_coupon", $post['coupon'], $acfUserID);
                    }

                    $loginResult = wp_signon(
                        array(
                            'user_login'    => $email,
                            'user_password' => $pass,
                            'remember'      => true 
                        )
                    );

                    // Handle newsletter signup
                    if(isset($post['newsletter_signup']) && $post['newsletter_signup'] == 'on'){
                        $settings = new Global_Settings();
                        $apiKey  = $settings->getGlobalSetting('mailchimp_api_secret');
                        $result  = null;

                        if($apiKey != null){
                            $mchmp  = new MailChimp($apiKey);
                            $listId = $settings->getGlobalSetting('mailchimp_signup_list_id');

                            if($listId != null){
                                $email = $post['email'];
                                $data = [
                                    'email_address' => $email,
                                    'status'        => 'pending',
                                    'merge_fields'  => array(
                                        'FNAME'      => $post['first_name'],
                                        'LNAME'      => $post['last_name'],
                                        'TYPE'       => 1,
                                        'SOURCE'     => 'Quiz',
                                        'QUIZSTATUS' => 1 // Indicate that the user has started the quiz, but not finished it.
                                    )
                                ];

                                $endpoint = 'lists/' . $listId . '/members';

                                $result = $mchmp->post($endpoint, $data);
                            }

                        } else {
                            $error = new WP_Error( 'apiKey', 'Could not authenticate with email provider. Please check site settings.');
                            $resp->message = $error->get_error_message();
                        }
                    }

                    delete_post_meta($newUserID, 'quiz_answers');

                    $resp->status  = true;
                    $resp->message = 'User Created!';
                    $resp->redirectURL = '/quiz';

                } else {
                    $proceed       = false;
                    $resp->message = $newUserID->get_error_message();
                }
            }            
        }

        if( $subaction === 'question_response' ){
            $qid          = $post['current_id'];
            $questionResp = $post['question_' . $qid];
            
            // returns either true for success or WP_Error for a problem.
            $this->saveQuizAnswerData($post);
            $result = $this->saveQuizQuestionData($qid, $post['question_' . $qid]);

            if($result instanceof WP_Error){
                $resp->status = false;
                $resp->message = $result->get_error_message();
            } else {
                $resp->status = true; 
                $resp->data = $this->getQuizNavigationData($qid, true);
            }
        }

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
                    $resp->data = array('msg' => 'Loading Results...', 'containerClass' => 'resultsPage');
                    // $resp->html = $this->getResultsScreen();

                    // lets check for whether the user saved a coupon code when they first signed up
                    $aeneaUser = new Aenea_User(wp_get_current_user());
                    $hasCoupon = (bool) get_field( "user_signed_up_with_coupon", 'user_'. $aeneaUser->user->ID);

                    // First, lets update the mailchimp data to indicate the user has finished the quiz.

                    $settings = new Global_Settings();
                    $apiKey  = $settings->getGlobalSetting('mailchimp_api_secret');
                    $result  = null;

                    if($apiKey != null){
                        $mchmp  = new MailChimp($apiKey);
                        $listId = $settings->getGlobalSetting('mailchimp_signup_list_id');

                        if($listId != null){
                            $email = $aeneaUser->user->user_email;
                            $userHash = md5(strtolower($email));                            
                            $data = [
                                'email_address' => $email,
                                'merge_fields'  => array(
                                    'QUIZSTATUS' => 0 // Indicate that the user has started the quiz, but not finished it.
                                )
                            ];

                            $endpoint = 'lists/' . $listId . '/members/' . $userHash;

                            $result = $mchmp->put($endpoint, $data);
                        }

                    } else {
                        $error = new WP_Error( 'apiKey', 'Could not authenticate with email provider. Please check site settings.');
                        $resp->message = $error->get_error_message();
                    }


                    // If they have one and it's valid, we will use that and assume it will make the signup free.
                    if($hasCoupon){
                        $this->getResultsScreen();

                        // unset this to make sure no values get to the function.
                        $_POST['mepr_process_signup_form'] = 1;
                        $_POST['mepr_product_id'] = '4789';
                        $_POST['mepr_transaction_id'] = '';
                        $_POST['mepr_stripe_txn_amount'] = 0;
                        $_POST['logged_in_purchase'] = '1';
                        $_POST['mepr_payment_method'] = "qqi4vj-1a8";
                        $_POST['mepr_no_val'] = '';
                        $_REQUEST['mepr_payment_methods_hidden'] = 1;
                        
                        $_POST['user_first_name'] = $aeneaUser->user->first_name;
                        $_POST['user_last_name']  = $aeneaUser->user->last_name;
                        $_POST['first_name']      = $aeneaUser->user->first_name;
                        $_POST['last_name']       = $aeneaUser->user->last_name;
                        $_POST['user_email']      = $aeneaUser->user->user_email;

                        $_POST['mepr-address-one'] = '';
                        $_POST['mepr-address-two'] = '';
                        $_POST['mepr-address-city'] = 'Charleston';
                        $_POST['mepr-address-country'] = 'US';
                        $_POST['mepr-address-state'] = 'SC';
                        $_POST['mepr-address-zip'] = '29403';

                        $_POST['mepr_coupon_code'] = get_field( "user_course_coupon", 'user_'. $aeneaUser->user->ID);

                        $checkout_ctrl = MeprCtrlFactory::fetch('checkout');
                        $result = $checkout_ctrl->process_signup_form($hasCoupon, true);

                        if($result['success']){
                            $resp->redirectURL = '/my-curriculum';
                            $resp->status = true;
                        }
                    } else {
                        $resp->status = true;
                        $resp->html = $this->getResultsScreen();
                    }
                } else {
                    $id = (int) $post['next_question_id'];
    
                    $q = new Question($id);
                    $resp->data = array('msg' => 'Loading Next Question...');
                    $resp->html = $q->getQuestionForm($id, $this->getQuizNavigationData($id, true));
                }
            }
        }

        if($direction === 'back'){
            if(isset($post['next_question_id'])){
                if($post['prev_question_id'] === 'register'){
                    $resp->data = array('msg' => 'Loading Registration Form...');
                    $resp->html = $this->getRegisterForm();
                } else {
                    $id = (int) $post['prev_question_id'];
        
                    $q = new Question($id);
                    $resp->data = array('msg' => 'Loading Previous Question...');
                    $resp->html = $q->getQuestionForm($id, $this->getQuizNavigationData($id, true));
                }
            }            
        }

        echo $resp->encodeResponse();
      
        die(0);
    }

    //////////////////////////////////////////////////////////////// 
    //////////////// EXPLICIT CRUD OPERATIONS ////////////////////// 
    ////////////////////////////////////////////////////////////////

    public function saveQuizQuestionData($id, $data){
        $result    = true;
        $aeneaUser = new Aenea_User(wp_get_current_user());
        
        if($id !== null && !empty($data)){
            $finalList    = array();
            $settings     = new Global_Settings();

            $formattedData = array();
            
            // convert new data to proper format
            if( is_array($data) ){
                foreach( $data as $module ){
                    $formattedData[] = (int) $module; 
                }
            } else {
                $formattedData[] = (int) $data;
            }

            // Get default modules
            $basicModules = $this->maybeArray($settings->getBasicModules());
            $currModules  = $this->maybeArray($aeneaUser->getModulesList());

            $finalList = array_merge( $basicModules, $currModules, $formattedData);

            $uniq = array_unique($finalList);

            $result = $aeneaUser->saveOrUpdateQuizModulesList( $uniq );
        } 
        
        return $result;
    }


    public function saveQuizAnswerData($data){
        $aeneaUser = new Aenea_User(wp_get_current_user());
        $id = 'user_' . (int) $aeneaUser->user->ID;
        $result = false;

        if($aeneaUser !== null && !empty($data)){
            $currentData = get_field('quiz_answers', $id);
            
            if(!$currentData){
                $currentData = array();
            }            

            if($data){
                $answers = explode('|', $data['question_answers']);
                $newData = array(
                    'quiz_question' => $data['question_text'],
                    'quiz_question_answers' => array(),
                );

                if(count($answers) > 0 ){
                    foreach($answers as $k => $answer){
                        $newData['quiz_question_answers'][] = array(
                            'quiz_answer' => $answer
                        );
                    }
                }
            }

            $currentData[] = $newData;

            $result = update_field('quiz_answers', $currentData, $id);
        } 
        
        return $result;
    }
}