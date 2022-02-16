<?php $html = '';

if ( is_array($accordionItem) ) {

    $title   = $accordionItem['title'];
    $id      = $accordionItem['id'];
    $key     = $accordionItem['idx']; 
    $content = $accordionItem['content'];
    $tag     = $accordionItem['tag'];
    $class   = $accordionItem['class']; ?>

    <<?php echo $tag;?> data-accordion-item class="<?php echo $class ?>">
        <button data-accordion-trigger
                id="<?php echo $id ?>-trigger"
                aria-expanded="false"
                aria-controls="<?php echo $id ?>-section">
            <?php echo $key; ?>. <?php echo $title; ?>
        </button>
        <div data-accordion-content
             id="<?php echo $id ?>-section"
             role="region"
             aria-labelledby="<?php echo $id ?>-trigger">
            <?php echo $content; ?>
        </div>
    </<?php echo $tag;?>>

<?php }

return $html;
