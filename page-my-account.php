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
      <div class="accountCurriculumMessage">
        <div><h2>Looking for Your Custom Course?</h2></div>
        <div><a class="btn btn-primary btn-small" role="button" href="/my-curriculum/">Go to My Curriculum</a></div>
      </div>
      <div class="pageContent">
        <?php the_content(); ?>
      </div>
    </section>
  </div>
</div>

<?php get_footer(); ?>
