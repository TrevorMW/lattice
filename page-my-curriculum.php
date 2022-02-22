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
      <h2><span class="introBlurp">Now Playing...</span><span data-lesson-title><?php echo $firstLesson->post->post_title; ?></span></h2>
    </header>

    <?php echo $firstLesson->getLessonVideoHtml() ?>

    <div data-lesson-finished>
        <a href="" class="btn btn-secondary btn-large" disabled data-lesson-id="<?php echo $firstLesson->post->ID ?>">Mark Complete <i class="fa fa-fw fa-check"></i></a>
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

<div class="wrapper turqToAqua centered resources">
    <div class="container">
        <h3>Climb the Lattice With Us</h3><div class="container x-small"><div class="grid ctaGrid twoByTwo"><div class="gridItem resourceCTA">
                        <div class="resourceImage">
                        <img src="http://localhost/~trevor.wagner/lattice/wp-content/uploads/2022/01/podcast-380x380.png" alt="" title="podcast" height="380" width="380"></div>
                        <div class="resourceTitle"><h4><a href="http://localhost/~trevor.wagner/lattice/podcast/" title="Podcast ">Listen to our podcast</a></h4></div>
                      </div><div class="gridItem resourceCTA">
                        <div class="resourceImage">
                        <img src="http://localhost/~trevor.wagner/lattice/wp-content/uploads/2022/01/laptop-380x380.png" alt="" title="laptop" height="380" width="380"></div>
                        <div class="resourceTitle"><h4><a href="http://localhost/~trevor.wagner/lattice/blog/" title="Blog ">Read our Blog</a></h4></div>
                      </div></div></div>    </div>
</div>

<?php if ($curr->hasNewLessons()) { ?> 
  <div class="wrapper cream addLaceBottom centered newLessons">
      <div class="container">
        <header>
          <h4>Newest Lessons</h4>
        </header>
        <br />
        <div class="newLessonCardList">
          <?php echo $curr->getNewestLessons();?>
        </div>
      </div>
  </div>
<?php } ?>

<?php get_footer(); ?>
