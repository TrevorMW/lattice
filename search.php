<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div class="primary" role="structure">
  <section class="page">

    <?php if ( have_posts() ) : ?>

      <header class="page-header">
        <h1 class="page-title" role="heading">
  	  	  <?php printf( __( 'Search Results for: %s', 'themename' ), '<span>' . get_search_query() . '</span>' ); ?>
        </h1>
      </header>
      
      <div class="page-content">
        <?php get_template_part( 'loop', 'search' ); ?>
      </div>

    <?php else : ?>

      <article class="post">
        
        <header class="post-header">
          <h1 class="post-title" role="heading">
            <?php _e( 'Nothing Found', 'themename' ); ?>
          </h1>
        </header>
        
        <div class="post-content">
          <p>
            <?php _e( 'Sorry, but nothing matched your search criteria. Please try again .', 'themename' ); ?>
          </p>
        </div>

      </article>
    
    <?php endif; ?>

  </section>
</div>
<div class="secondary" role="structure">
  <?php dynamic_sidebar('blog');  ?> 
</div>
<?php get_footer(); ?>
