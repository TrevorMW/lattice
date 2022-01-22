<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); 

$quiz = new Quiz($post->ID); ?>

<div class="container x-small">
  <div class="primary">
    <section class="page" role="article">
      <div class="page-content">
        <?php the_content(); ?>
        <br />
        <?php echo $quiz->getRegisterForm(); ?>
      </div>
    </section>
  </div>
</div>
<?php get_footer(); ?>
