<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

<?php if(is_front_page()){ ?> 
</main>
<?php } else { ?> 
    </div>
</main>
<?php } ?>

<footer>
	<div class="wrapper sand footer">
		<div class="container flexed">
			<div>
				<nav class="footerNav">
					<ul>
						<?php wp_nav_menu(array(
							'menu'           => 'footer',
							'theme_location' => 'footer',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 0
						)) ?>
					</ul>
				</nav>
			</div>
			<div class="">
				
			</div>
			<div class="">
				
			</div>
			<div class="">
				<div>
					<a href="YOUR FACEBOOK LINK" title="Facebook" target="_blank" rel="noopener">
					<span class="social"><i class="fa fa-facebook"></i></span></a>

					<a href="YOUR TWITTER LINK" title="Twitter" target="_blank" rel="noopener">
					<span class="social"><i class="fa fa-twitter"></i></span></a>

					<a href="YOUR PINTEREST LINK" title="Pinterest" target="_blank" rel="noopener">
					<span class="social"><i class="fa fa-pinterest"></i></span></a>

					<a href="YOUR INSTAGRAM LINK" title="Instagram" target="_blank" rel="noopener">
					<span class="social"><i class="fa fa-instagram"></i></span></a>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper subFooter">
		<div class="container flexed">
			<div class="alignLeft">
				<nav class="footerUtility">
					<ul>
						<li><a href="YOUR FACEBOOK LINK" title="Facebook" target="_blank" rel="noopener">
							<span class="social"><i class="fa fa-facebook"></i></span></a></li>

						<li><a href="YOUR TWITTER LINK" title="Twitter" target="_blank" rel="noopener">
							<span class="social"><i class="fa fa-twitter"></i></span></a></li>

						<li><a href="YOUR PINTEREST LINK" title="Pinterest" target="_blank" rel="noopener">
							<span class="social"><i class="fa fa-pinterest"></i></span></a></li>

						<li><a href="YOUR INSTAGRAM LINK" title="Instagram" target="_blank" rel="noopener">
							<span class="social"><i class="fa fa-instagram"></i></span></a></li>
					</ul>
					<ul>
						
						
						<?php wp_nav_menu(array(
							'menu'           => 'footer-utility',
							'theme_location' => 'footer-utility',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 0
						)) ?>
					</ul>
				</nav>
			</div>
			<div>
				<p>
					Copyright &copy; 2021 Chalkline
				</p>	
			</div>
		</div>
	</div>
</footer>

<div data-overlay>
	<div><i class="fa fa-spin fa-spinner fa-pulse fa-fw"></i></div>
</div>

<div data-popup="mainPopup">
	<a data-destroy><i class="fa fa-fw fa-times-circle"></i></a>
	<div class="table-cell">
		<div class="popup-body">
			<header class="popup-header">
				<h3>Hello World</h3>
			</header>
			<div class="popup-content">
				<p>content goes here</p>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>