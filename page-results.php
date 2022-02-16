<?php

/**
 * Template Name: Template - Results
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header();
the_post();

$quiz = new Quiz(); ?>

<div class="container">
  <div class="primary">
    <section class="page" role="article">
      <div class="page-content">
        <br>
        <div class="aeneaQuiz resultsPage" data-quiz-container>
          <?php echo $quiz->getResultsScreen();?>
        </div>
      </div>
    </section>
  </div>
</div>

<?php get_footer(); ?>