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
			<div></div>
			<div class="logo">
				<div class="desktopLogo">
					<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/static/img/logo.png" alt=""/></a>
				</div>
				<div class="mobileLogo">
					<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/static/img/mobile_logo.png" alt=""/></a>
				</div>
			</div>
			<div>
				<?php if( is_user_logged_in() ){ ?>
					<a href="" data-mobile-nav-trigger>
						<i class="fa fa-bars"></i>
					</a>
				<?php } else { ?>
					<a href="" data-popup-trigger="signin_form">Sign In</a>
				<?php } ?>
			</div>
		</header>
	</div>

	

	<?php if(is_front_page()){ ?> 
		<main class="wrapper cream mainContent frontPage">
	<?php } else { 

		$title 	 = $post->post_title;
		$blog_id = get_option('page_for_posts');
		
		if(is_home() && have_posts()){
			$title = get_post((int) $blog_id)->post_title;
		} ?> 

		<div class="wrapper turqToAqua centered InnerPageHero">
			<div class="container">
				<header class="page-header">
					<h1 class="page-title" role="heading">
						<?php echo $title ?>
					</h1>
				</header>
			</div>	
		</div>

		<?php if($post->post_name === 'my-curriculum') { ?> 
			<main class="wrapper cream addLaceTop mainContent InnerPage">
		<?php } else { ?> 
			<main class="wrapper cream addLace mainContent InnerPage">
		<?php } ?>
		
	<?php } ?>