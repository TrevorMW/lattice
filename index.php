<?php
/**
 * @package WordPress
 * @subpackage themename
 */

$blog_id = get_option('page_for_posts'); 

get_header(); ?>

<div class="container" role="structure">
  <div class="primary" role="structure">
    <section class="page posts-page">
      <div class="page-content">
        <?php $post = get_post( $blog_id ); $post->post_content; ?><hr />
        <?php get_template_part( 'loop', 'index' ); ?>
      </div>
    </section>
  </div>
  <div class="secondary" role="structure">
    <?php dynamic_sidebar('blog'); ?>
  </div>
</div>
<?php  get_footer(); ?>
