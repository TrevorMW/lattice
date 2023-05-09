<?php

/**
 *
 * @package    WordPress
 * @subpackage themename
 */

get_header();
the_post();

$home = new Homepage($post->ID); ?>

<div class="wrapper turqToAqua centered frontpageHero">
    <div class="container">
        <section>
            <?php echo $home->getHomepageHero(); ?>
        </section>
    </div>
</div>

<div class="wrapper cream addLace centered timelineContent">
    <div class="container">
        <section>
            <?php $donationTitle = get_field('donation_title', $post->ID); ?>
            <?php if($donationTitle){ ?> <h2><?php echo $donationTitle ?></h2><?php } ?>
            <div class="donationWidget">
                <script>
                    gl = document.createElement('script');
                    gl.src = 'https://secure.givelively.org/widgets/simple_donation/lattice-climbers.js?show_suggested_amount_buttons=false&show_in_honor_of=false&address_required=false&has_required_custom_question=null&prefilled_donation_amount=25';
                    document.getElementsByTagName('head')[0].appendChild(gl);
                </script>
                <div id="give-lively-widget" class="gl-simple-donation-widget"></div>
            </div>
            <?php echo $home->getHomepageTimeline(); ?>
        </section>
    </div>
</div>

<div class="wrapper turqToAqua centered featuredModules">
    <div class="container">
        <section>
            <?php echo $home->getHomepageFeaturedModules(); ?>
        </section>
    </div>
</div>

<div class="wrapper cream addLace centered yourJourney">
    <div class="container">
        <?php echo $home->getHomepageJourney(); ?>
    </div>
</div>

<div class="wrapper turqToAqua centered resources">
    <div class="container">
        <?php echo $home->getHomepageResources(); ?>
    </div>
</div>

<div class="wrapper cream addLace centered">
    <div class="container">
        <?php echo $home->getHomepageNewsletterSignup(); ?>
    </div>
</div>

<?php get_footer(); ?>