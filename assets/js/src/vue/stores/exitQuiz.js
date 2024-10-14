import { defineStore } from 'pinia';
import axios from 'Axios';

export const exitQuizStore = defineStore('exitQuizStore', {
    state: () => {
        return {
            loaded: false,
            grade: '',
            isStarted: false,
            isFinished: false,
            userPassed: false,
            certificate: [],
            questions: [],
            quizData: [],
            currentQuestion: null,
            currentQuestionIndex: 0,
            isLoading: false
        }
    },
    actions: {
        async loadData() {
            this.loaded = false;
            const data = new FormData();

            data.append('action', 'load_exit_quiz_data')

            return axios.post(core.ajaxUrl, data).then((resp) => {
                if (resp.status === 200 && resp.data) {
                    Object.assign(this, {...resp.data.data});
                    
                    setTimeout(() => {
                        this.loaded = true;
                    }, 1000)
                }

                return resp;
            })
        },
        async startExitQuiz() {
            const data = new FormData();

            data.append('action', 'start_exit_quiz')

            return axios.post(core.ajaxUrl, data).then((resp) => {
                if (resp.status === 200 && resp.data) {
                    Object.assign(this, {...resp.data.data});
                }

                return resp;
            })
        },
        async submitAnswer(data) {
            this.isLoading = true;
            data.append('action', 'submit_exit_quiz_answer');

            return axios.post(core.ajaxUrl, data).then((resp) => {
                this.isLoading = false;
                return resp;
            })
        },
        async resetQuiz(){
            const data = new FormData();

            data.append('action', 'reset_exit_quiz');

            return axios.post(core.ajaxUrl, data).then((resp) => {
                return resp;
            })
        }
    }
});