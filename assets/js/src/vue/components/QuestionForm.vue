<script setup>
import { computed, defineProps, ref, onUpdated } from 'vue';
import { storeToRefs } from 'pinia';
import { exitQuizStore } from '../stores/exitQuiz';

const eqStore = exitQuizStore();
const emits = defineEmits(['answerSubmitted'])

const {
    loaded,
    currentQuestion
} = storeToRefs(eqStore);

const questionForm = ref(null);

const props = defineProps({
    question: {
        type: Object, 
        required: true
    },
    isLoading: {
        type: Boolean, 
        required: true
    }
});

const questionID = computed(() => {
    const id = props.question.questionPost.ID;
    return `question_${id}`;
})

const submitAnswer = () => {
    emits('answerSubmitted', { form: questionForm.value, id:  props.question.questionPost.ID })
}

// onUpdated(() => {
//     const radios = questionForm.value.querySelector('input[type="radio"]');

//     if(radios){
//         radios.forEach((val) => {
//             console.log(val)
//         })
//     }
// })
</script>

<template>
    <form @submit.prevent="submitAnswer" ref="questionForm" validate :id="question.id">
        <fieldset class="exitQuizQuestion">
            <h4>{{ question.questionAsked }}</h4>
            <p v-html="question.helpText" />
        </fieldset>

        <fieldset class="exitQuizAnswers">
            <div class="formControl formControlRadio" v-for="(answer, idx) in question.answers">
                <label :for="`${questionID}_${idx}`">
                    <div><input required type="radio" :name="questionID" :value="answer.answer_value" :id="`${questionID}_${idx}`" :tabindex="idx"></div>
                    <div v-html="answer.answer_title"></div>
                </label>
            </div>
        </fieldset>

        <fieldset class="questionSubmit">
            <hr />
            <div class="submitButton">
                <button type="submit" class="btn btn-primary btn-small"><span v-if="isLoading"><i class="fa fa-fw fa-spinner fa-spin"></i></span>Submit</button>
            </div>
        </fieldset>
    </form>
</template>

<style lang="scss">
</style>