<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php echo site_global_description(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/media/favicon.ico">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div class="wrapper headerBar">
		<header class="container flexed">
			<div class="logo">
				<a href="/"><img src="<?php echo get_template_directory_uri() ?>/assets/static/img/croppedChalklineLogo.png" alt=""/></a>
				<h1 class="screenReader">COMPANY TITLE</h1>
			</div>
			<div class="alignRight">
				<nav class="mainNav">
					<ul>
						<?php wp_nav_menu(array(
							'menu'           => 'primary',
							'theme_location' => 'primary',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 0
						)) ?>
						<li><a href data-search-trigger><i class="fa fa-search"></i></a></li>
					</ul>
				</nav>
			</div>
		</header>
	</div>

<?php if(is_front_page()){ ?> 
<main>
<?php } else { 
	
// $blog_id = get_option('page_for_posts');

// if(is_home()){
// 	$post = get_post( $blog_id );
// }

?> 

<div class="hero basicHero">
	<div class="hero-inner">
		<div class="hero-body">
			<h1 class="hero-heading" style="color:#fff;"><?php echo $post->post_title ?></h1>
		</div>
	</div>
	<picture>
		<img src="<?php echo get_template_directory_uri() ?>/assets/static/img/workbelt-original.jpg" alt="Shop Nixon Great Minds Gifts">
	</picture>
</div>
<main class="wrapper mainContent">
    <div class="container small">  

<?php } wp_reset_postdata(); ?>