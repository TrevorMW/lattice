<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header();  the_post(); ?>

<div class="container small">
  <div class="primary">
    <article class="post individualPost" role="article">
      <div class="entryContent">
        <?php the_content(); ?>
      </div>
    </article>
  </div>
</div>
<?php get_footer(); ?>
