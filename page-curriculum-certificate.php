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

$loggedIn = is_user_logged_in();
$curr = new Curriculum();
$isFinished = $curr->isFinished; 

$gs = new Global_Settings();
$cert = new Certificate($gs->postID); ?>

<?php if ($loggedIn && $isFinished) { ?>
  <div class="certificatePage">
    <div class="container centered certHeader">
      <h1>&#x1F389; Congratulations! &#x1F389; </h1>
      <p>You have successfully completed your custom Lattice Climbers curriculum! You can download your certificate below!
      </p>
      <br /><br />
      <a href="" data-cert-download-link download="<?php echo $downloadTitle ?>" class="btn btn-secondary"><span><i
            class="fa fa-fw fa-download"></i></span>&nbsp;&nbsp;&nbsp;<span>Download Certificate</span></a>
    </div>
    <div class="container certificateImage">
      <canvas width="1200" height="900" data-certificate-canvas data-image-url="<?php echo $cert->image['url'] ?>" data-cert-name="<?php echo $cert->name ?>"></canvas>
    </div>
  </div>
<?php } ?>

<?php get_footer(); ?>