<?php $html = ''; 

if( is_object($post) ){ 
    
    $permalink = get_permalink($post->ID);
    $title     = get_the_title($post->ID); ?>

    <article class="post blogPost" role="article">
        <div class="entry entryContent">
            <a href="<?php echo $permalink; ?>">
                <header class="entryHeader">
                    <h1 class="postTitle" role="heading">
                        <?php echo $title; ?>
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
                    <?php echo get_excerpt_by_id($post, 25, false); ?>
                </div>
            </a>        
        </div>

    </article>

<?php }