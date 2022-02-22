<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header();  the_post(); $lesson = new Lesson($post->ID); ?>

<div class="container small">
  <div class="primary">
      <article class="post individualPost" role="article">
        <div class="entryMeta">
            <?php printf( __( '<span class="meta-prep meta-prep-author">Posted on </span>
                              <a href="%1$s" rel="bookmark">
                                <time class="entry-date" datetime="%2$s" pubdate>%3$s</time>
                              </a> ', 'themename' ),
                              get_permalink(),
                              get_the_date( 'c' ),
                              get_the_date()
            ); ?>	
          </div>
        
        <div class="entryContent">
          <?php echo $lesson->getLessonVideoHtml();?>
          
          <?php the_content(); ?>
        </div>

      </article>
  </div>
</div>
<?php get_footer(); ?>
