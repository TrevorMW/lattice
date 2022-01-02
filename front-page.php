<?php
/**
 *
 * @package    WordPress
 * @subpackage themename
 */

get_header();
the_post(); ?>

    <div class="hero hero-left">
        <div class="hero-inner">
            <div class="hero-body">
                <p class="hero-subheading">Chalkline Renovations + Repairs</p>

                <h1 class="hero-heading">We Keep It Straight!</h1>
                
                <div class="hero-cta-group">
                    <a class="btn btn-primary" href="https://www.nixon.com/us/en/gifts/mens-gifts">Shop Men's</a>
                </div>
            </div>
        </div>
        <picture>
            <img src="<?php echo get_template_directory_uri() ?>/assets/static/img/workbelt.jpg"
                alt="Shop Nixon Great Minds Gifts">
        </picture>
    </div>

    <div class="wrapper darkGray ctaBar topCtaBar">
        <div class="container">
            <div class="alignCenter">
                <h2 class="">What Can <strong style="color:crimson;">Chalkline</strong> Do for you?</h2>
            </div>
        </div>
    </div>

    <div class="wrapper introBlocks">
        <div class="wrapper introBlock ">
            <div class="container flexed">
                <section class="introBlockImage"> 
                    <img width="1707" height="2560" src="<?php echo get_template_directory_uri() ?>/assets/static/img/contractor_at_work.jpg">

                </section>
                <section class="introBlockContent">
                    <div class="introBlockContentInner">
                        <h2>About Chalkline</h2>
                        <p>Locally owned business with over 35 years of experience in building, construction and welding. </p>
                        <a class="btn" href="">Learn More</a>
                    </div>
                </section> 
                
            </div>
        </div>

        <div class="wrapper introBlock introBlockRight">
            <div class="container small flexed">
                <section class="introBlockImage"> 
                    <img width="1707" height="2560" src="<?php echo get_template_directory_uri() ?>/assets/static/img/contractor_at_work.jpg">

                </section>
                <section class="introBlockContent">
                    <div class="introBlockContentInner">
                        <h2>Our Capabilities</h2>
                        <p>From Consultation &amp; Collaboration all the way to a finished product!</p>
                        <a class="btn" href="/">Learn More</a>
                    </div>
                </section> 
                
            </div>
                            
        </div>
    </div>

    <div class="wrapper darkGray ctaBar middleCtaBar">
        <div class="container flexed">
            <div>
                <h2 class="">Lets talk about your project!</h2>
            </div>
            <div class="alignRight">
                <a class="btn btn-primary" href=""><i class="fa fa-phone"></i>&nbsp; Give us a Call</a>
                <a class="btn btn-secondary" href=""><i class="fa fa-envelope"></i>&nbsp;  Contact Us</a>
            </div>
        </div>
    </div>

<?php get_footer(); ?>