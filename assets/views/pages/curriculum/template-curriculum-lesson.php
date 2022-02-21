<?php $html = '';

if( is_array($lesson) ){ 

    $title   = $lesson['title'];
    $id      = $lesson['id'];
    $slug    = $lesson['slug']; 
    $status  = $lesson['completed'] ?>

    <li>
        <a href="#" data-curriculum-lesson="<?php echo $id ?>">
            <span>
                <?php if ($status){ ?> 
                    <i class="fa fa-fw fa-check"></i>
                <?php } else { ?> 
                    <i class="fa fa-fw fa-play"></i>
                <?php } ?>
            </span>
            <span><?php echo $title?></span>
        </a> 
    </li>

<?php } 