import { createPinia } from 'pinia'

import exitQuizApp from '../src/vue/apps/ExitQuizApp';

const pinia = createPinia();

document.addEventListener("DOMContentLoaded", function(event) { 
    const exitQuiz = document.getElementById('exitQuiz');
    
    if(exitQuiz){
        new exitQuizApp(exitQuiz, pinia);
    }
});
