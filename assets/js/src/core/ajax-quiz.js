import AjaxForm from './ajax-form';

/**
 * @package     Quiz
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class AjaxQuiz {
	constructor() {
		this.quiz = {
			container: null,
			backBtn: null
		};

		this.init();

		return this;
	}

	init() {
        const quizContainer = $('[data-quiz-container]'),
			  backBtn 		= $('[data-back-btn]');

        if(quizContainer.length > 0){
            this.quiz.container = quizContainer;
            this.setObservers();
        }		
	}

	setObservers() {
		var self = this;

		$(document).on('core:request:success', (e, data) => {
			var resp = data.resp;			

			if(resp.data.canProceed){
				this.loadNewQuestion(resp.data.next);
			}
		});
	}

	loadNewQuestion(id){
		var self = this;

		if(id){
			$.ajax({
				method: 'POST',
				dataType: 'html',
				url: core.ajaxUrl,
				data:{
					action:'load_question_form',
					question_id: id
				},
			})
			.then((html) => {
				// replace question HTML
				self.quiz.container.html(html);

				// Rebind AjaxForm
				const ajaxForm = new AjaxForm();
				ajaxForm.setObservers();
			}).catch((err) => {

			})
		}
	}
}
