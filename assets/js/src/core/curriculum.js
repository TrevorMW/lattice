import Accordion from './accordion';
import Tabs from './tabs';

/**
 * @package     Curriculum
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class Curriculum {
	constructor() {
		this.curriculum = {
			container: null,
			title: null,
			progress: null,
			video: null,
			tabs: null,
			doneBtn: null,
			modules: null,
		};

		this.lessonTriggers = null;

		this.init();

		return this;
	}

	init() {
		const curriculum = $('[data-curriculum]');
		const inst = this.curriculum;

		if (curriculum.length > 0) {
			const title = $('[data-lesson-title]');
			const video = $('[data-lesson-player]');
			const tabs = $('[data-lesson-tabs]');
			const doneBtn = $('[data-lesson-finished] .btn');
			const progress = $('[data-lesson-progress-bar]');
			const modules = $('[data-modules-list]');

			inst.container = curriculum;

			if (curriculum.length > 0) {
				inst.container = curriculum;
			}

			if (title.length > 0) {
				inst.title = title;
			}

			if (video.length > 0) {
				inst.video = video;
			}

			if (tabs.length > 0) {
				inst.tabs = tabs;
			}

			if (doneBtn.length > 0) {
				inst.doneBtn = doneBtn;
			}

			if (progress.length > 0) {
				inst.progress = progress;
			}

			if (modules.length > 0) {
				inst.modules = modules;
			}

			const lessonTriggers = $('[data-curriculum-lesson]');

			if (lessonTriggers.length > 0) {
				this.lessonTriggers = lessonTriggers;
			}

			this.setObservers();
		}
	}

	setVimeoObservers() {
		var self = this;

		if (typeof Vimeo == 'object') {
			const iframe = $('[data-lesson-player] iframe');

			if (iframe.length > 0) {
				const player = new Vimeo.Player(iframe[0]);

				player.on('ended', function () {
					self.enableCompleteButton();
				});
			}
		}
	}

	setObservers() {
		var self = this;
		
        if (this.lessonTriggers.length > 0) {
			this.lessonTriggers.each((idx, el) => {
				const trigger = $(el);

				trigger.on('click', (e) => {
					const trigger  = $(e.target).closest('a');
					const lessonID = trigger.data('curriculumLesson');

					e.preventDefault();
 
					$(document).trigger('curriculum:lesson:load', { lessonID : lessonID })
				});
			});
		}

		$(document).on('curriculum:lesson:load', (e, data) => {
			const id = data.lessonID;

			self.disableCompleteButton();
			self.loadLessonData(id);
		});

		$(document).on('curriculum:lesson:done', (e, data) => {
			const id = data.lessonID;

			if(id){
				self.markAsDone(id);
			}
		});

		this.setDoneButtonObservers();
		this.setVimeoObservers();
	}

	setDoneButtonObservers(){

		if (this.curriculum.doneBtn.length > 0) {
			const btn = this.curriculum.doneBtn;

			btn.on('click', (e) => {
				e.preventDefault();
				const btn = $(e.target);
				const lessonID = btn.data('lessonId');
				
				if(!btn.is(":disabled")){
					$(document).trigger('curriculum:lesson:done', { lessonID : lessonID });
				}
			});
		}
	}

	disableCompleteButton() {
		this.curriculum.doneBtn.attr('disabled', 'disabled');
	}

	enableCompleteButton() {
		this.curriculum.doneBtn.removeAttr('disabled');
	}

	updateElement(el, content) {
		el.html(content);
	}

	markAsDone(id) {
		var self = this;

		if (id) {
			$.ajax({
				method: 'POST',
				url: core.ajaxUrl,
				data: {
					action: 'mark_done',
					lesson_id: id,
				},
				dataType: 'json',
			}).then((resp) => {
				if (resp.status) {
					self.disableCompleteButton();
					self.loadProgressBar();
					self.markLessonItemDone(id);
				}
			});
		}
	}

	markLessonItemDone(id){

		if(id){
			const lesson = $('[data-curriculum-lesson="' + id + '"]');

			if(lesson.length > 0){
				const i = lesson.find('i.fa');

				if( i.length > 0){
					lesson.removeClass('play').addClass('done');
					i.removeClass('fa-play').addClass('fa-check');
				}
			}
		}
	}

	loadModulesList() {
		var self = this;

		$.ajax({
			method: 'POST',
			url: core.ajaxUrl,
			data: {
				action: 'load_modules',
			},
			dataType: 'json',
		}).then((resp) => {
			if (resp.status) {
				if (resp && 'data' in resp && 'modules' in resp.data) {
					const modules = resp.data.modules;

					self.updateElement(self.curriculum.modules, modules);

					new Accordion();
				}
			}
		});
	}

	loadProgressBar() {
		var self = this;

		$.ajax({
			method: 'POST',
			url: core.ajaxUrl,
			data: {
				action: 'load_progress',
			},
			dataType: 'json',
		}).then((resp) => {
			if (resp.status) {
				if (resp && 'data' in resp && 'progress' in resp.data) {
					const progress = resp.data.progress;

					self.updateElement(self.curriculum.progress, progress);
				}
			}
		});
	}

	loadLessonData(id) {
		var self = this;

		if (id) {
			$.ajax({
				method: 'POST',
				url: core.ajaxUrl,
				data: {
					action: 'load_lesson',
					lesson_id: id,
				},
				dataType: 'json',
			}).then((resp) => {
				if (resp.status) {
					if (resp && 'data' in resp && 'title' in resp.data) {
						const title = resp.data.title;

						self.updateElement(self.curriculum.title, title);
					}

					if (resp && 'data' in resp && 'tabs' in resp.data) {
						const tabs = resp.data.tabs;

						self.updateElement(self.curriculum.tabs, tabs);
					}

                    if (resp && 'data' in resp && 'video' in resp.data) {
						const video = resp.data.video;

						self.updateElement(self.curriculum.video, video);
					}

					const btn = $('[data-lesson-id]');

					if (btn.length > 0) {
						if (resp && 'data' in resp && 'id' in resp.data) {
							const id = resp.data.id;

							btn.data('lessonId', id);
							btn.attr('data-lesson-id', id);
						}
					}

					new Tabs();

					self.setVimeoObservers();
				}
			});
		}
	}
}
