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

			const lessonTriggers = $('[data-curriculum-lesson]');

			if (lessonTriggers.length > 0) {
				this.lessonTriggers = lessonTriggers;
			}

			this.setObservers();
		}
	}

	setVimeoObservers() {
		// if(typeof Vimeo == 'object'){
		//     const iframe = $('[data-lesson-player] iframe');
		//     const player = new Vimeo.Player(iframe);
		//     console.log(player);

		//     player.on('ended', function() {
		//         console.log('Finished.');
		//     });
		// }

		if (this.lessonTriggers.length > 0) {
			this.lessonTriggers.each((idx, el) => {
				const trigger = $(el);

				trigger.on('click', (e) => {
					const trigger = $(e.target).closest('a');

					e.preventDefault();

					this.loadLessonData(trigger.data('curriculumLesson'));
				});
			});
		}
	}

	setObservers() {
		this.setVimeoObservers();
	}

	disableCompleteButton() {}

	enableCompleteButton() {}

	updateElement(el, content) {
		el.html(content);
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

					const btn = $('[data-lesson-id]');

					if (btn.length > 0) {
						if (resp && 'data' in resp && 'id' in resp.data) {
							const id = resp.data.id;

                            btn.attr('data-lesson-id', id);
						}
					}

					new Tabs();
				}
			});
		}
	}
}
