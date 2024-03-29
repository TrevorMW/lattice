<?php $html = '';

if( is_array($module) ){ 

    $title   = $module['title'];
    $id      = $module['id'];
    $content = $module['content'];
    $tag     = $module['tag'];
    $class   = $module['class'];
    $status  = $module['status'];?>

    <<?php echo $tag;?> data-accordion-item class="<?php echo $class ?>">
        <button data-accordion-trigger
                id="<?php echo $id ?>-trigger"
                aria-expanded="false"
                aria-controls="<?php echo $id ?>-section">
                <span data-module-finished> <?php if($status){ ?> <i class="fa fa-fw fa-check"></i> <?php } ?> </span>
            <?php echo $title; ?>
        </button>
        <div data-accordion-content
             id="<?php echo $id ?>-section"
             role="region"
             aria-labelledby="<?php echo $id ?>-trigger">
            <?php echo $content; ?>
        </div>
    </<?php echo $tag;?>>
    

<?php } 
