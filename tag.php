<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div class="primary" role="structure">
  <section class="page" role="article">
    <header class="page-header">
      <h1 class="page-title" role="heading">
        <?php printf( __( 'Tag Archives: %s', 'themename' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
      </h1>
    </header>
    <div class="page-content">
       <?php rewind_posts(); ?>

	   <?php get_template_part( 'loop', 'tag' ); ?>
    </div>
  </section>
</div>

<?php get_sidebar(); get_footer(); ?>