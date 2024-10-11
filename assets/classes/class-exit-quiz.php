<?php
/**
 * @package     ExitQuiz
 * @author      Trevor Wagner
 * @copyright   Trevor Wagner
 * @license     GPL-2.0+
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Class ExitQuiz
 */
class Exit_Quiz
{
    public $user; // current logged in user
    public $userData; // user's data
    public $userQuestionData; // initial question data to be saved as user data
    public $questions; // current set questions
    public $questionIndex = 0; // current quiz index, based on how many questions have been answered
    public $grade; // user's quiz grade
    public $isFinished; // has user finished quiz?
    public $userPassed; // did user fail quiz? 

    public function __construct($userID = null)
    {
        if ($userID) {
            $aeneaUser = new Aenea_User($userID);
            $this->user = $aeneaUser->user;
            $this->questions = $this->getQuestions();
            $this->userData = $this->getUserData($this->user);
            $this->grade = $this->getGrade($this->user);
            $this->userPassed = $this->grade >= 80 ? true : false;
            $this->questionIndex = $this->getCurrentQuestionID(); // if this is null, then we are finished
        } else {
            $this->registerAjax();
        }
    }

    public function registerAjax()
    {
        add_action('wp_ajax_nopriv_load_exit_quiz_data', array($this, 'loadExitQuiz'));
        add_action('wp_ajax_load_exit_quiz_data', array($this, 'loadExitQuiz'));

        add_action('wp_ajax_nopriv_submit_exit_quiz_answer', array($this, 'submitAnswer'));
        add_action('wp_ajax_submit_exit_quiz_answer', array($this, 'submitAnswer'));

        add_action('wp_ajax_nopriv_load_next_exit_quiz_question', array($this, 'loadNextQuestion'));
        add_action('wp_ajax_load_next_exit_quiz_question', array($this, 'loadNextQuestion'));

        add_action('wp_ajax_nopriv_start_exit_quiz', array($this, 'startExitQuiz'));
        add_action('wp_ajax_start_exit_quiz', array($this, 'startExitQuiz'));

        add_action('wp_ajax_nopriv_reset_exit_quiz', array($this, 'resetExitQuiz'));
        add_action('wp_ajax_reset_exit_quiz', array($this, 'resetExitQuiz'));
    }

    public function getCurrentQuestionID()
    {
        // always start out here, that way when they first start, we get the first question in the array
        $id = array_key_first($this->questions);

        // then we check to find the first question that hasnt been answered in the user data. We use that to find the current question someone should be set to.
        if ($this->userData) {
            $allAnswered = true;
            foreach ($this->userData as $k => $q) {
                if (!$q['answered']) {
                    $id = $k;
                    $allAnswered = false;
                    break;
                }
            }

            if ($allAnswered) {
                $id = null;
            }
        }

        return $id;
    }

    public function getQuestions()
    {
        $questions = [];
        $data = get_field('exit_quiz_questions', get_option('page_for_settings'));

        if ($data) {
            foreach ($data as $questionPost) {
                $questions[$questionPost->ID] = array(
                    'id' => $questionPost->ID,
                    'questionPost' => $questionPost,
                    'questionAsked' => $questionPost->post_title,
                    'questionFormat' => get_field('question_format', $questionPost->ID),
                    'answers' => get_field('question_with_one_answer', $questionPost->ID),
                    'correctAnswer' => get_field('correct_answer', $questionPost->ID),
                    'helpText' => apply_filters('the_content', $questionPost->post_content)
                );
            }
        }

        if ($questions) {
            return $questions;
        }
    }

    public function getGrade($user)
    {
        $data = get_field('exit_quiz_score', 'user_' . $user->ID);

        if ($data) {
            return ((float) $data * 100);
        }
    }

    public function getUserData($user)
    {
        return maybe_unserialize(get_field('exit_quiz_data', 'user_' . $user->ID));
    }

    public function createInitialUserData()
    {
        $qs = $this->questions;
        $data = [];

        if ($qs) {
            foreach ($qs as $question) {
                $data[$question['questionPost']->ID] = array(
                    'answered' => false,
                    'answeredCorrectly' => false,
                    'score' => 0,
                );
            }
        }

        $this->updateExitQuizUserScore(0, $this->user);

        return $data;
    }

    public function updateUserData($data, $user)
    {
        $this->userData = $data;
        return update_field('exit_quiz_data', maybe_serialize($data), 'user_' . $user->ID);
    }

    public function updateExitQuizUserScore($score, $user)
    {
        return update_field('exit_quiz_score', $score, 'user_' . $user->ID);
    }

    public function isProvidedAnswerCorrect($answer, $id)
    {
        $isCorrect = false;

        if ($answer && $id) {
            $q = $this->questions[$id];

            $correctAnswer = $q['correctAnswer'];

            if ($correctAnswer === $answer) {
                $isCorrect = true;
            }
        }

        return $isCorrect;
    }

    public function calculateCurrentScore()
    {
        $score = null;

        // gotta check if we have questions, otherwise we cant do math
        if (is_array($this->questions)) {
            // get the total # of Questions
            $outOf = count($this->questions);

            // total all the scores of each question out of the user data
            $answered = 0;

            if ($this->userData) {
                foreach ($this->userData as $q) {
                    if ($q['answered']) {
                        $answered += (int) $q['score'];
                    }
                }
            }

            $score = $answered / $outOf;
        }

        return $score;
    }

    public function getCurrentQuestion()
    {
        $index = 0;

        if ($this->userData) {

        }

        return $index;
    }

    public function getCertificateData()
    {
        $cert = array(
            'link' => '',
            'title' => '',
            'image' => '',
            'name' => ''
        );

        $curr = new Curriculum();
        $isFinished = $curr->isFinished;

        $gs = new Global_Settings();
        $certificate = new Certificate($gs->postID);

        if ($isFinished && $this->userPassed) {
            $cert['image'] = $certificate->image['url'];
            $cert['name'] = $certificate->name;
        }

        return $cert;
    }

    public function loadExitQuiz()
    {
        $resp = new Ajax_Response($_POST['action']);
        $user = wp_get_current_user();
        $exit = new Exit_Quiz($user->ID);

        $resp->data = array(
            'isStarted' => $exit->userData ? true : false,
            'isFinished' => $exit->questionIndex === null ? true : false,
            'userPassed' => $exit->userPassed,
            'grade' => $exit->grade,
            'questions' => $exit->questions,
            'quizData' => $exit->userData,
            'currentQuestion' => $exit->questions[$exit->questionIndex],
            'certificate' => $exit->getCertificateData()
        );

        echo $resp->encodeResponse();

        die(0);
    }

    public function startExitQuiz()
    {
        $user = wp_get_current_user();
        $resp = new Ajax_Response($_POST['action']);
        $exit = new Exit_Quiz($user->ID);

        $userData = $exit->createInitialUserData();

        if ($userData) {
            $exit->updateUserData($userData, $exit->user);
            $exit->updateExitQuizUserScore($exit->calculateCurrentScore(), $exit->user);
        }

        $resp->data = array(
            'isStarted' => $exit->userData ? true : false,
            'isFinished' => $exit->questionIndex === null ? true : false,
            'userPassed' => $exit->userPassed,
            'grade' => $exit->grade,
            'questions' => $exit->questions,
            'quizData' => $exit->userData,
            'currentQuestion' => $exit->questions[$exit->questionIndex],
            'certificate' => $exit->getCertificateData()
        );

        echo $resp->encodeResponse();

        die(0);
    }

    public function submitAnswer()
    {
        $user = wp_get_current_user();
        $resp = new Ajax_Response($_POST['action']);
        $exit = new Exit_Quiz($user->ID);

        $userData = $exit->getUserData($user);

        // if the user has a data object we can update, then proceed
        if (!$userData) {
            $resp->status = false;
            $resp->message = 'Could not save answer to current question. Please restart the quiz.';
        } else {
            $questionID = $_POST['question_id'];

            if (!$questionID) {
                $resp->status = false;
                $resp->message = 'Could not save answer to current question. Please restart the quiz.';
            } else {
                $answer = $_POST['question_' . $questionID];

                $answerCorrect = $exit->isProvidedAnswerCorrect($answer, $questionID);

                $userData[$questionID]['answered'] = true;
                $userData[$questionID]['answeredCorrectly'] = $answerCorrect;
                $userData[$questionID]['score'] = $answerCorrect ? 1 : 0;

                $exit->updateUserData($userData, $exit->user);
                $exit->updateExitQuizUserScore($exit->calculateCurrentScore(), $exit->user);

                $resp->status = true;
                $resp->message = "Answer saved successfully!";
            }
        }

        echo $resp->encodeResponse();
        die(0);
    }

    public function resetExitQuiz()
    {
        $user = wp_get_current_user();
        $resp = new Ajax_Response($_POST['action']);
        $exit = new Exit_Quiz($user->ID);

        $userData = $exit->createInitialUserData();

        if ($userData) {
            $exit->updateUserData($userData, $exit->user);
            $exit->updateExitQuizUserScore(0, $exit->user);
        }
        
        echo $resp->encodeResponse();

        die(0);
    }
}