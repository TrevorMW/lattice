<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); 

the_post(); 

$podcast = new Podcast($post->ID); ?>

<div class="container x-small">
  <div class="primary">
      <article class="podcast" role="article">  

        <?php echo $podcast->getPodcastPlayer(); ?>

        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
      
      <nav id="nav-below" class="pagination postPagination" role="navigation">
        <div class="nav-prev"><?php previous_post_link( '%link',  _x( '&larr;', 'Previous post link', 'themename' ) . ' %title' ); ?></div>
        <div class="nav-next"><?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'themename' ) ); ?></div>
      </nav>
  </div>
</div>
<?php get_sidebar(); get_footer(); ?>
