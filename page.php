<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div class="container">
  <div class="primary">
    <section class="page" role="article">
      <div class="page-content">
        <?php the_content(); ?>
      </div>
    </section>
  </div>
</div>

<?php get_footer(); ?>
