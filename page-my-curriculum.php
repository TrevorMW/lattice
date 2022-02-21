<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); 

$curr = new Curriculum();
$firstLesson = $curr->getInitialLesson();?>

<div class="container flexed alignTop">
  <div class="primary curriculumPlayer" data-curriculum>
    <header>
      <h2><span class="introBlurp">Now Playing</span><br /><span data-lesson-title><?php echo $firstLesson->post->post_title; ?></span></h2>
    </header>

    <div data-lesson-progress-bar>
      <?php echo $curr->getCurriculumProgressBar(); ?>
    </div>
    
    <div class="lessonPlayer" data-lesson-player>
      <iframe src="https://player.vimeo.com/video/<?php echo $firstLesson->getVideoID(); ?>?loop=0&amp;title=0&amp;byline=0&amp;muted=0&amp;color&amp;autopause=0&amp;autoplay=0" frameborder="0" allowfullscreen="1" allow="encrypted-media;"></iframe>
    </div>

    <div data-lesson-tabs>
      <?php echo $firstLesson->getLessonTabHTML(); ?>
    </div>
    
  </div>
  <div class="secondary curriculumModuleList">

    <div data-lesson-finished>
        <a href="#" class="btn btn-secondary btn-large" disabled data-lesson-id="<?php echo $firstLesson->post->ID ?>">Mark Complete <i class="fa fa-fw fa-check"></i></a>
    </div>
    
    <?php echo $curr->getCurriculumModulesHTML(); ?>
  </div>
</div>

<?php get_footer(); ?>
