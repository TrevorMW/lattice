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