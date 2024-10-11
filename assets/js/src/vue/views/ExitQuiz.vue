<script setup>
import { ref, onMounted, watch, nextTick } from 'vue';
import { storeToRefs } from 'pinia';
import { exitQuizStore } from '../stores/exitQuiz';
import Cert from '../../core/cert.js';

import QuestionForm from '../components/QuestionForm.vue'
import GlobalLoader from '../components/GlobalLoader.vue'

const eqStore = exitQuizStore();
const transition = ref(false);

const {
    loaded,
    grade,
    isStarted,
    isFinished,
    userPassed,
    certificate,
    currentQuestion,
} = storeToRefs(eqStore);

const startQuiz = () => {
    transition.value = true;
    eqStore.startExitQuiz().then(() => {
        transition.value = false;
    });
}

const submitAnswer = (val) => {
    let data = new FormData(val.form);
    data.append('question_id', val.id);

    eqStore.submitAnswer(data).then((resp) => {
        setTimeout(() => {
            eqStore.loadData()
        }, 1500);
    });
}

const getGradePercentage = () => {
    return `${grade.value}%`;
}

const restartQuiz = () => {
    eqStore.resetQuiz().then(() => {
        eqStore.loadData();
    })
}

onMounted(() => {
    eqStore.loadData()
});

watch(userPassed, (val) => {
    nextTick(() => {
        if(val){
            const canv = document.querySelector('[data-certificate-canvas]')
            new Cert();
        }
    });
})
</script>

<template>
    <GlobalLoader v-if="!loaded"/>

    <div v-if="loaded && !isStarted && !isFinished" class="exitQuizStartPage">
        <div>
            <h6>In order to recieve your completion certificate, you must first take our exit quiz! </h6>
            <br />
            <button :class="[{ 'btn btn-primary hasLoader': true, 'loading': transition }]" @click.prevent="startQuiz" ref="startQuizBtn"><i class="fa fw fa-spin fa-spinner"></i>Start Quiz</button>
        </div>
    </div>

    <!-- If we've started and the quiz isnt finished, assume were rendering a question -->
    <div v-if="loaded && isStarted && !isFinished" class="">
        <QuestionForm :question="currentQuestion" 
                      :isLoading="transition.value"
                      @answerSubmitted="submitAnswer"/>
    </div>

    <!-- If we've finished the quiz, and passed, show the certificate! -->
    <div v-if="loaded && isFinished && userPassed" class="quizPassed">
        <div class="certificatePage">
            <div class="container centered certHeader">
                <h1>&#x1F389; Congratulations! &#x1F389;</h1>
                <h4>You scored {{ getGradePercentage() }}!</h4>
                <p>You have successfully completed your custom Lattice Climbers curriculum! <br />You can download your certificate below!</p>
                <a href="" data-cert-download-link download="" class="btn btn-secondary"><span><i class="fa fa-fw fa-download"></i></span>&nbsp;&nbsp;&nbsp;<span>Download Certificate</span></a>
            </div>
            <div class="container certificateImage">
                <canvas width="1200" height="900" data-certificate-canvas :data-image-url="certificate.image" :data-cert-name="certificate.name"></canvas>
            </div>
        </div>

    </div>

    <!-- If weve finished, but didnt pass, lets inform the user, and give them a button to restart the test. -->
    <div v-if="loaded && isFinished && !userPassed" class="quizFailed">
        <p>Unfortunately, you scored {{ getGradePercentage() }}, which was below the 80% needed to earn your diploma. But not to worry, you can try again!</p>
        <button @click="restartQuiz" class="btn btn-primary">Restart Exit Quiz</button>
    </div>

</template>