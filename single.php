<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header();  the_post(); ?>

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
