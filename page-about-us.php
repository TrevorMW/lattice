<?php
/**
 * Template Name: Template - Generic
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); 
the_post(); 

$about = new About_Us($post->ID);
$team  = new Team_Member($post->ID) ?>

<div class="container">
  <div class="primary">
    <section class="page" role="article">
      <div class="page-content">
        <?php the_content(); ?>
      </div>
    </section>
  </div>
</div>

<div class="wrapper darkBlue weInspire">
  <div class="container centered">
    <?php echo $about->getInspirationContent(); ?>
  </div>
</div>  

<div class="wrapper teamMemberGrid">
  <div class="container centered">
    <?php echo $about->getTeamMemberGrid(); ?>
  </div>
</div>

<?php get_footer(); ?>
