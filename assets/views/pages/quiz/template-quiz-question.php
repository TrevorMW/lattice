<?php $html .= '';

if(is_array($question)){ ?>

    <h4><?php echo $question['q_title']; ?></h4>

    <p><?php echo $question['q_help_text']; ?></p>
    <hr />

    <form data-ajax-form data-action="aenea_quiz">
        <div data-form-msg></div>

        <input type="hidden" name="next_question_id"  value="question_<?php echo $question['q_next'] ?>" />
        <input type="hidden" name="prev_question_id"  value="question_<?php echo $question['q_prev'] ?>" />
        <input type="hidden" name="currentQuestionID" value="<?php echo (int)$question['q_idx'] ?>" />


        <?php if( $question['q_type'] === 'checkboxes' ){  $i = 0; ?> 
            
            <?php foreach( $question['q_selections'] as $q ){ 
                
                $fieldSlug = sanitize_title($q['q_type_checkbox_title']);  ?> 
                
                <div class="formControl formControlCheckbox">
                    <label for="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>">
                        <div><input type="checkbox" name="question_<?php echo $question['q_idx'] ?>[]" value="<?php echo $q['q_type_checkbox_value']->post_name ?>" id="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>" tabindex="<?php echo $i?>"></div>
                        <div><?php echo $q['q_type_checkbox_title'] ?></div>
                    </label>
                </div>
            
            <?php $i++; } ?>
            
        <?php } ?>


        <?php if( $question['q_type'] === 'radios' ){ $i = 0; //var_dump($question); ?> 
            
            <?php foreach( $question['q_selections'] as $q ){ 
                
                $fieldSlug = sanitize_title($q['q_type_radio_title']);  ?> 
                
                <div class="formControl formControlRadio">
                    <label for="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>">
                        <div><input type="radio" name="question_<?php echo $question['q_idx'] ?>" value="<?php echo $q['q_type_radio_value']->post_name ?>" id="question_<?php echo $question['q_idx'] ?>_<?php echo $fieldSlug ?>" required tabindex="<?php echo $i?>"></div>
                        <div><?php echo $q['q_type_radio_title'] ?></div>
                    </label>
                </div>
            
            <?php $i++; } ?>
            
        <?php } ?>

        <?php if( $question['q_type'] === 'text' ){ ?> 
            
            <?php foreach( $question as $q ){ ?> 
            
            
            <?php } ?>
            
        <?php } ?>

        <hr />

        <div class="submitButton">
            <button data-quiz-back class="btn btn-secondary btn-small">&larr; Back</button>&nbsp;<button type="submit" data-submit class="btn btn-primary btn-small">Submit</button>
        </div>

    </form>

<?php }

return $html;