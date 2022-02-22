import Progress from './progress';

/**
 * @package     AjaxForm
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class AjaxForm {
	constructor() {
		this.form = {
			el: null,
			action: null,
			confirm: false,
			submit: null,
			url: null
		};

		this.data  = { formData: null };
		this.flags = { canSubmit: false, showProgress:true };

		return this;
	}

	init(form, url) {
		if (form.length > 0) {
			this.form.el = form;
			this.form.submit = form.find('[data-submit]');
			this.form.action = form.data('action');
			this.form.url = url;

			if (form.data('confirm') !== undefined) {
				this.form.confirm = form.data('confirm');
			}
		}

		this.collectData();

		if (this.confirmFormRequest()) {
			if(!this.flags.showProgress){
				$(document).trigger('core:progress:show', { form: this.form.el, msg: 'Saving Data...' });
			}

			this.makeRequest(this);
		} else {
			if(!this.flags.showProgress){
				$(document).trigger('core:progress:hide');
			}
		}
	}

	setObservers() {
		var self = this,
			ajaxForm = $('[data-ajax-form]'),
       		backBtn = $('[data-quiz-back]');
		
		if(ajaxForm.length > 0){
			ajaxForm.on('submit', (e) => {
				e.preventDefault();

				var form    = $(e.currentTarget),
					formMsg = form.find('[data-form-msg]');

				if (formMsg.length > 0) {
					$(document)
						.trigger('core:message:init', { formMessage: formMsg })
						.trigger('core:message:hide');
				}

				self.init(form, core.ajaxUrl);
			});	

			ajaxForm.each((idx, el) => {
				const form = $(el);
				new Progress(form);
			});
		}

		$(document).on('core:popup:contentLoaded', (e, data) => {
			const popupContent = data.popup;
			const form = popupContent.find('[data-ajax-form]');

			if(popupContent.length > 0 && form.length > 0){

				if(!form[0].hasAttribute('data-no-progress')){
					self.flags.showProgress = false;
				}

				if(!self.flags.showProgress){
					new Progress(form);
				}
			}
		});

		if (backBtn) {
			backBtn.on('click', (e) => {
				e.preventDefault();

				const el = $(e.currentTarget);

				if (el.length > 0) {
					const form = el.closest('[data-quiz-container]').find('[data-ajax-form]');

					if (form.length > 0) {
						const prev = form
							.find('input[name="prev_question_id"]')
							.val();

						$(document).trigger('quiz:form:previous', {
							prev_question_id: prev,
						});
					}
				}
			});
		}

	}

	collectData() {
		this.data.formData = this.form.el.serialize();
	}

	confirmFormRequest() {
		return this.form.confirm !== false ? confirm(this.form.confirm) : true;
	}

	makeRequest() {
		var self = this;

		// Ajax POST call using native DW library.
		$.ajax({
			method: 'POST',
			action: this.form.action,
			url: this.form.url,
			data: this.data.formData + '&action=' + this.form.action,
			success: (resp) => {
				
				if(!this.flags.showProgress){
					$(document).trigger('core:progress:hide');
				}
				
				this.formSuccess(resp);
			},
		});
	}

	formSuccess(resp) {
		let response = JSON.parse(resp);

		$(document).trigger('core:message:show', { resp: response });
		
		if (response.status && response.pageRefresh) {
			if (response.redirectURL !== null) {
				window.location = response.redirectURL;
			} else {
				location.reload();
			}
		} else {
			$(document).trigger('core:request:success', {
				form: self,
				resp: response,
			});
		}
	}
}
