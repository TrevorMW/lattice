<?php $html = '';

if(is_array($quizdata)){
    $plan       = $quizdata['membership_plan'];
    $moduleHtml = $quizdata['module_html'];?>

    <div class="resultsVideo">
        <iframe src="https://player.vimeo.com/video/<?php echo $quizdata['intro_video'] ?>?loop=0&amp;title=0&amp;portrait=0&amp;byline=0&amp;muted=0&amp;color&amp;autopause=0&amp;autoplay=1" frameborder="0" allowfullscreen="1" allow="autoplay;encrypted-media;"></iframe>
        <br />
        <div class="courseUnlockCTA">
            <a href="<?php echo get_permalink($plan->ID); ?>" 
               class="btn btn-primary btn-large">
               Unlock Your Courses Now!
            </a>
        </div>
    </div>

    <div class="resultsModules">
        <h4><?php echo $quizdata['results_title'] ?></h4>
        <hr />
        
        <?php if($moduleHtml) { ?> 
            <div class="aenea_curriculum_container">
                <?php echo $moduleHtml; ?> 
            </div>
        <?php } ?>

    </div>

<?php } 

return $html;