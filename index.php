<?php
/**
 * @package WordPress
 * @subpackage themename
 */

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$blog_id = get_option('page_for_posts'); 

get_header(); ?>

<div class="container" role="structure">
  <div class="primary" role="structure">
    <section class="page postsPage">
        <?php $post = get_post( $blog_id ); $post->post_content; ?>
        <div class="blogPostGrid"><?php get_template_part( 'loop', 'index' ); ?></div>
        <?php if (  $wp_query->max_num_pages > 1 ) :?>
          <div class="pagination paginationBlogPosts">
            <?php echo build_pagination($wp_query, $paged); ?>
          </div>
        <?php endif; ?>
    </section>
  </div>
  <div class="secondary" role="structure">
    <?php dynamic_sidebar('blog'); ?>
  </div>
</div>
<?php  get_footer(); ?>
