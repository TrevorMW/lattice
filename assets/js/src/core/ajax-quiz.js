import AjaxForm from './ajax-form';

/**
 * @package     Quiz
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class AjaxQuiz {
	constructor() {
		this.quiz = {
			container: null		
		};

		this.init();

		return this;
	}

	init() {
        const quizContainer = $('[data-quiz-container]');

        if(quizContainer.length > 0){
            this.quiz.container = quizContainer;
            this.setObservers();
        }		
	}

	setObservers() {
		const self = this;

		$(document).on('core:request:success', (e, data) => {
			const resp = data.resp;	

			if(resp.data.canProceed){
				let msg = '';

				if(resp && 'data' in resp && 'msg' in resp.data){
					msg = resp.data.msg;
				}

				$(document).trigger('core:progress:show', { msg: msg });

				this.loadNewQuestion(resp.data.next, 'forward');
			}
		});

		$(document).on('quiz:form:previous', (e, data) => {
			var id = data.prev_question_id;

			$(document).trigger('core:progress:show');

			self.loadNewQuestion(id, 'back');
		});
	}

	loadNewQuestion(id, direction){
		const self = this;

		if(id){
			$.ajax({
				method: 'POST',
				dataType: 'json',
				url: core.ajaxUrl,
				data: this.quiz.container.find('[data-ajax-form]').serialize() + '&action=load_question_form' + '&direction=' + direction
			})
			.then((resp) => {
				$(document).trigger('core:progress:hide');

				// replace question HTML
				self.quiz.container.html(resp.html);
				
				if(resp.data && 'containerClass' in resp.data && resp.data.containerClass){
					$(document).trigger('core:quiz:results');
					
					self.quiz.container.addClass(resp.data.containerClass);
					self.quiz.container.closest('.InnerPage').find('.container').removeClass('x-small');
				}

				// Rebind AjaxForm
				const ajaxForm = new AjaxForm();
				ajaxForm.setObservers();

			}).catch((err) => {

			})
		}
	}
}
