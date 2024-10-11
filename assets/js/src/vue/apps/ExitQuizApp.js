import { createApp } from 'vue';

import ExitQuiz from '../views/ExitQuiz.vue';

export default function loadApp(el, pinia) {
    const app = createApp(ExitQuiz);

    if(pinia){
        app.use(pinia);
    }

    app.mount(el);
}
