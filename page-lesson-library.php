<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post();  

$library = new Library($post); ?>

<div class="container">
  <div class="primary">
      <section class="post courseList" role="article">  
        <div class="entry-content">
          <?php $content = get_field('introduction_blurp', $post->ID);
          
          if($content != null){ ?> <p> <?php echo $content; ?> </p><br /><?php }?>
        </div>
        <br />
        <div data-lesson-library>
          <div class="libraryToolbar">
            
            <div class="toolbarCourseSearch">
              <form class="inlineForm" method="GET" action="<?php echo $wp->request?>">
                <div class="courseSearchInput"><input type="search" placeholder="Search Course Library..." name="library_search_term" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+"/></div>
                <div class="courseSearchSubmit"><button type="submit" class="btn btn-primary">Search</button></div>
              </form>
            </div>
            <div class="toolbarCompletion">
              <?php echo $library->getCompletionData();?>
            </div>
          </div>
          
          <hr /><br />
          <?php echo $library->getAllLessons(); ?>
        </div>
      </section>
  </div>
</div>
<?php get_footer(); ?>
