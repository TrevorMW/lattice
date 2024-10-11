<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header();
the_post();

$curr = new Curriculum();
// need to make sure we have modules saved to a user first
$moduleList = Curriculum::parseModulesData();
$firstLesson = $curr->getInitialLesson();
$isFinished = $curr->isFinished; ?>

<?php if ($isFinished) { ?>
  <div class="container">
    <div class="ribbon finishedBanner">
      <h1>You have Finished Your Curriculum!</h1>
      <a href="/exit-quiz" class="btn btn-primary">Get your Certificate</a>
    </div>
  </div>
<?php } ?>
<div class="container flexed alignTop" data-exit-quiz-container>

  <?php if ($moduleList) { ?>
    <div class="primary curriculumPlayer" data-curriculum>
      <header>
        <h2><span class="introBlurp">Now Playing...</span><span
            data-lesson-title><?php echo $firstLesson->post->post_title; ?></span></h2>
      </header>

      <?php echo $firstLesson->getLessonVideoHtml() ?>

      <div data-lesson-finished>
        <a href="" class="btn btn-secondary btn-large" disabled
          data-module-id="<?php echo get_post_meta($firstLesson->post->ID, 'lesson_id')[0] ?>"
          data-lesson-id="<?php echo $firstLesson->post->ID ?>">Mark Complete <i class="fa fa-fw fa-check"></i></a>
      </div>

      <div data-lesson-tabs>
        <?php echo $firstLesson->getLessonTabHTML(); ?>
      </div>

    </div>
    <div class="secondary curriculumModuleList">

      <h3>Your Curriculum:</h3>
      <hr />

      <div data-lesson-progress-bar>
        <?php echo $curr->getCurriculumProgressBar(); ?>
      </div>

      <div data-modules-list>
        <?php echo $curr->getCurriculumModulesHTML(); ?>
      </div>
    </div>
  <?php } else { ?>
    <div class="primary alignCenter">
      <h5>Looks like you havent taken our quiz to generate a curriculum!</h5>
      <br />
      <a href="/quiz" class="btn btn-primary">TAKE QUIZ</a>
    </div>
  <?php } ?>
</div>

<?php

$id = (int) get_option('page_on_front');
$homepage = new Homepage($id); ?>

<div class="wrapper turqToAqua centered resources">
  <?php echo $homepage->getHomepageResources(); ?>
</div>

<div class="wrapper cream addLaceBottom centered newLessons">
  <div class="container">
    <header>
      <h4>Newest Lessons</h4>
    </header>
    <br />
    <div class="lessonCardGrid">
      <?php echo $curr->getNewestLessons(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>