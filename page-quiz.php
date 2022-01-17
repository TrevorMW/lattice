<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div class="primary">
  <section class="page" role="article">
    <div class="page-content">
      <?php the_content(); ?>
    </div>
  </section>
</div>

<?php get_sidebar(); get_footer(); ?>
