<?php
/**
 * Template Name: Exit Quiz
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header();
the_post();

$loggedIn = is_user_logged_in();
$curr = new Curriculum();
$isFinished = $curr->isFinished;

$gs = new Global_Settings(); ?>
<div class="container centered x-small page-quiz">
  <div class="primary">
    <?php if ($loggedIn && $isFinished) { ?>
      <div id="exitQuiz" data-exit-quiz-container></div>
    <?php } else { ?>
      Please login to gain access to your exit quiz!
    <?php } ?>
  </div>
</div>

<?php get_footer(); ?>