<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); 

$curr        = new Curriculum();
$firstLesson = $curr->getInitialLesson();?>

<div class="container flexed alignTop">
  <div class="primary curriculumPlayer" data-curriculum>
    <header>
      <h2><span class="introBlurp">Now Playing...</span><span data-lesson-title><?php echo $firstLesson->post->post_title; ?></span></h2>
    </header>

    <?php echo $firstLesson->getLessonVideoHtml() ?>

    <div data-lesson-finished>
        <a href="" class="btn btn-secondary btn-large" disabled data-module-id="<?php echo get_post_meta($firstLesson->post->ID, 'lesson_id')[0] ?>" data-lesson-id="<?php echo $firstLesson->post->ID ?>">Mark Complete <i class="fa fa-fw fa-check"></i></a>
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
        <?php echo $curr->getNewestLessons();?>
      </div>
    </div>
</div>

<?php get_footer(); ?>
