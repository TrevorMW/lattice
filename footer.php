<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

</main>

<footer>
	<div class="wrapper aquaToTurq centered footerBar">
		<div class="container flexed">
			<div class="leftFooterNav">
				<nav>
					<ul>
						<?php wp_nav_menu(array(
							'menu'           => 'footer-left',
							'theme_location' => 'footer-left',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 0
						)) ?>
					</ul>
				</nav>
			</div>
			<div class="logo">
				<a href="<?php echo home_url();?>"><img src="<?php echo get_template_directory_uri() ?>/assets/static/img/logo.png" alt=""/></a>
			</div>
			<div class="rightFooterNav">
				<nav>
					<ul>
						<?php wp_nav_menu(array(
							'menu'           => 'footer-right',
							'theme_location' => 'footer-right',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 0
						)) ?>
					</ul>
				</nav>
			</div>
		</div>
		<p>&copy; Copyright Aenea 2021</p>
	</div>
</footer>

<div data-mobile-nav class="">
	<div data-mobile-nav-close>
		<div>
			<a href="<?php echo home_url(); ?>"><i class="fa fa-home"></i></a>
		</div>
		<div>
			<a href="" data-mobile-nav-close-trigger>&times;</a>
		</div>
	</div>
	<nav class="mainNavAuthenticated">
		<ul>
			<?php wp_nav_menu(array(
				'menu'           => 'primary-authenticated',
				'theme_location' => 'primary-authenticated',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'depth'          => 0
			)) ?>

			<li class="signOutLink">
				<a href="<?php echo wp_logout_url()?>" data-sign-out class="btn btn-primary">Sign Out</a>
			</li>
		</ul>
	</nav>
</div>

<div data-popup>
	<div>
		<div class="popupBody">
			<header class="popupHeader">
				<div class="popupTitle" data-title></div>
				<div><a data-destroy>&times;</a></div>
			</header>
			<div class="popupContent" data-content>
			</div>
		</div>
	</div>
</div>

<?php $settings = new Global_Settings(); 

$gtmCode = $settings->getGlobalSetting('tag_manager_code');

if($gtmCode){ ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer', <?php echo $gtmCode?> );</script>
	<!-- End Google Tag Manager -->
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>