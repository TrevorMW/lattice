<?php
/**
 * Template Name: Template - Contact Us
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div class="container small">
  <div class="primary">
    <section class="page" role="article">
      <div class="page-content">
        <?php the_content(); ?>
      </div>
    </section>
  </div>
  <div class="secondary">
    
  </div>
</div>

<?php get_footer(); ?>
