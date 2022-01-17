<?php
/**
 * Template Name: Template - Podcasts
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post();?>

<div class="container">
  <div class="primary small">
    <section class="page" role="article">
      <div class="page-content">
        <?php the_content(); ?>
        <br />
        <?php echo Podcast::getPodcasts(); ?>
      </div>
    </section>
  </div>
</div>

<?php get_footer(); ?>
