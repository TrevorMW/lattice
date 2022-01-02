<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div class="primary">
  <section class="page">
    <header class="page-header">
      <h1 class="page-title" role="heading"> 
	  	  <?php printf( __( 'Category Archives: %s', 'themename' ), '<span>' . single_cat_title( '', false ) . '</span>' );?> 
      </h1>
      <div class="archive-meta">
        <?php $categorydesc = category_description();  
	          if ( ! empty( $categorydesc ) )  echo apply_filters( 'archive_meta', $categorydesc ); ?>
      </div>
    </header>
    <div class="page-content">
    	<?php get_template_part( 'loop', 'category' ); ?>
    </div>
  </section>
</div>

<?php get_sidebar(); get_footer(); ?>
