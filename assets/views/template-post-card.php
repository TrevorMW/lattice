<?php $html = ''; 

if( is_object($post) ){ 
    
    $permalink = get_permalink($post->ID);
    $title     = get_the_title($post->ID); 
    ?>

    <article class="post blogPost" role="article">

        <div class="entryImage">
            <?php echo get_the_post_thumbnail($post->ID);?>
        </div>

        <div class="entry entryContent">
            <header class="entryHeader">
                <h1 class="postTitle" role="heading">
                    <a href="<?php echo $permalink ?>" title="Read more of <?php echo $title; ?>"><?php echo $title; ?></a>
                </h1>

                <div class="postMeta">
                    <?php printf( __( '<span class="sep">Posted on </span>
                                        <a href="%1$s" role="link"><time class="entry-date" datetime="%2$s">%3$s</time></a> 
                                        <span class="sep">', 'themename' ),
                            get_permalink(),
                            get_the_date( 'c' ),
                            get_the_date()
                    );?>
                </div>
                
            </header>			

            <div class="entrySummary">		
                <?php echo get_excerpt_by_id($post->ID); ?>
            </div>
            
            <div class="entryReadMore"><a href="<?php echo $permalink; ?>" class="btn btn-tertiary">Read More</a></div>
        </div>

    </article>

<?php }