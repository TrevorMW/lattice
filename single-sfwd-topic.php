<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header();  the_post(); $lesson = new Lesson($post->ID); ?>

<div class="container small">
  <div class="primary">
      <article class="post individualPost" role="article">    
        <div class="entryContent">
          <?php echo $lesson->getLessonVideoHtml();?>       
          <?php the_content(); ?>
        </div>
        <br />
        <hr/>
        <br />
        <div class="topicTabs">
            <?php echo $lesson->getLessonTabHTML(); ?>
        </div>

      </article>
  </div>
</div>
<?php get_footer(); ?>
