<?php $html = '';

if(is_array($progress)){ ?>

<div class="progressBar">
    <div class="progressBarLabel">
        <div><label for="curriculum">Curriculum Progress:</label></div>
        <div><?php echo $progress['percent']; ?><span class="hideMobile">&nbsp;Complete</span></div>
    </div>
    
    <progress id="curriculum" max="<?php echo $progress['max']; ?>" value="<?php echo $progress['state'] ?>"><?php echo $progress['percent']; ?></progress>
</div>

<?php }

return $html;