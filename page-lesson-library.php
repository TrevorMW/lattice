<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post();  

$library = new Library($post); ?>

<div class="container">
  <div class="primary">
      <article class="post courseList" role="article">  
        <div class="entry-content">
          <p><?php $content = get_field('introduction_blurp', $post->ID);
          
          if($content != null){ echo $content; }?></p>
        </div>
        <br />
        <div data-lesson-library>
          <?php echo $library->getCompletionData();?>
          <hr /><br />
          <?php echo $library->getAllLessons(); ?>
        </div>
      </article>
  </div>
</div>
<?php get_footer(); ?>
