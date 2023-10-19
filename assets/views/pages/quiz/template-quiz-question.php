<?php $html = '';

$classes = count($question['q_selections']) <= 2 || $question['q_type'] === 'range' ? 'formControlInlineInputs' : '' ;
$classes .= $question['q_type'] === 'range' ? ' formControlInlineRangeInputs' : '';

if(is_array($question)){ ?>

    <h4><?php echo $question['q_title']; ?></h4>

    <p><?php echo $question['q_help_text']; ?></p>
    <hr />
    <br />
    <form data-ajax-form data-action="aenea_quiz">
        <input type="hidden" name="subaction" value="question_response" />
        <input type="hidden" name="question_text"     value="<?php echo $question['q_title'] ?>" />
        <input type="hidden" name="next_question_id"  value="<?php echo $question['q_next'] ?>" />
        <input type="hidden" name="prev_question_id"  value="<?php echo $question['q_prev'] ?>" />
        <input type="hidden" name="current_id"        value="<?php echo (int)$question['q_idx'] ?>" />
        <input type="hidden" name="question_type"     value="<?php echo $question['q_type'] ?>" />
        <input type="hidden" name="question_answers"  data-question-answers />

        <div data-form-msg></div>

        <fieldset class="<?php echo $classes; ?>"> 

            <?php if( $question['q_type'] === 'checkboxes' ){  $i = 0; ?> 
                
                <?php foreach( $question['q_selections'] as $q ){ 
                    
                    $fieldSlug = sanitize_title($q['q_type_checkbox_title']); 
                    $values = is_array($q['q_type_checkbox_value']) ? implode('|', $q['q_type_checkbox_value']) : $q['q_type_checkbox_value']  ?> 
                    
                    <div class="formControl formControlCheckbox">
                        <label for="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>">
                            <div><input type="checkbox" name="question_<?php echo $question['q_idx'] ?>[]" value="<?php echo implode('|', $q['q_type_checkbox_value']) ?>" id="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>" tabindex="<?php echo $i?>"></div>
                            <div><?php echo $q['q_type_checkbox_title'] ?></div>
                        </label>
                    </div>
                
                <?php $i++; } ?>
                
            <?php } ?>

            <?php if( $question['q_type'] === 'radios' ){ $i = 0; ?> 
                
                <?php foreach( $question['q_selections'] as $q ){ 
                    
                    $fieldSlug = sanitize_title($q['q_type_radio_title']);  ?> 
                    
                    <div class="formControl formControlRadio">
                        <label for="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>">
                            <div><input type="radio" name="question_<?php echo $question['q_idx'] ?>" value="<?php echo $q['q_type_radio_value'] ?>" id="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>" required tabindex="<?php echo $i?>"></div>
                            <div><?php echo $q['q_type_radio_title'] ?></div>
                        </label>
                    </div>
                
                <?php $i++; } ?>
                
            <?php } ?>

            <?php if( $question['q_type'] === 'range' ){ ?> 
                
                <?php foreach( $question['q_selections'] as $q ){
                    
                    $fieldSlug = sanitize_title($q['q_type_radio_range_title']);  
                    $values = is_array($q['q_type_radio_range_value']) ? implode('|', $q['q_type_radio_range_value']) : $q['q_type_radio_range_value'] ?> 
                    
                    <div class="formControl formControlRadioRange">
                        <label for="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>">
                            <div><input type="radio" name="question_<?php echo $question['q_idx'] ?>" value="<?php echo $values?>" id="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>" required tabindex="<?php echo $i?>"></div>
                            <div><?php echo $q['q_type_radio_range_title'] ?></div>
                        </label>
                    </div>
                
                <?php $i++; } ?>
                
            <?php } ?>

        </fieldset>

        <hr />

        <div class="submitButton">
            <button type="submit" data-submit class="btn btn-primary btn-small">Submit</button>
        </div>

    </form>

    <?php if( $question['q_prev'] !== null){ ?>
        <button data-quiz-back class="btn btn-small btn-link">&larr; Back</button>
    <?php } ?>

<?php }

return $html;