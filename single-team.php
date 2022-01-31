<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header();  the_post(); ?>

<div class="container x-small">
  <div class="primary">
      <article class="post teamMemberPost" role="article">
        <div class="teamMemberImage">
          <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
        </div>
        
        <div class="entryContent">
          <?php the_content(); ?>
        </div>
      </article>

      <nav class="pagination postPagination" role="navigation">
        <div class="nav-prev"><?php previous_post_link( '%link',  _x( '&larr;', 'Previous post link', 'themename' ) . ' %title' ); ?></div>
        <div class="nav-next"><?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'themename' ) ); ?></div>
      </nav>
      
  </div>
</div>

<?php get_footer(); ?>
