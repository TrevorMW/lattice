
/**
 * @package     Popup
 * @version     1.0
 * @author      Trevor Wagner
 */
export default class Popup {
	constructor(el, id, title, content) {
		this.popup = {
			el: null,
			id: null,
			title: null,
			content: null
		}

		this.init(el, id, title, content);

		return this;
	}

	init(el, id, title, content) {
		const self = this;

		if (el !== null || el !== undefined) {
			self.popup.el = el;

			// check for predefined content. If none, and ID present, make ajax call for content
			if (id !== null || id !== undefined) {
				self.popup.id = id;
			}

			if (title !== null || title !== '') {
				self.popup.title = title;
			}

			if (content !== null || content !== '') {
				self.popup.content = content;
			}
		}

		self.setObservers();
	}

	setObservers() {
		const self = this;

		$(self.popup.el).find('[data-destroy]').on('click', () => {
			$(document).trigger('core:popup:hide', self.popup.el);
		});

		$(document).on('core:popup:show', (e, data) => {

			self.loadContent(self.popup.id, (html) => {
				if (html !== null) {
					self.populateContent(self.popup.title, html);
				} else {
					self.populateContent(self.popup.title, self.popup.content);
				}

				$(document).trigger('core:popup:contentLoaded', { popup: self.popup.el });
			});

			self.show();
		});

		$(document).on('core:popup:hide', (e) => {
			self.hide();
		});
	}

	show() {
		const self = this;

		self.lockBody(true);
		self.popup.el.addClass('active');
		self.popup.el.addClass('popup-' + self.popup.id);

		setTimeout(
			function (popup) {
				popup.addClass('visible');

				$(document).trigger('core:popup:open');
			},
			300,
			this.popup.el
		);
	}

	hide() {
		const self = this;
		const titleEl = self.popup.el.find('[data-title]');
		const contentEl = self.popup.el.find('[data-content]')

		self.popup.el.removeClass('visible');
		self.popup.el.removeClass('active');

		titleEl.html('');
		contentEl.html('');

		self.popup.el.removeClass('contentLoaded');
		self.popup.el.removeClass('popup-' + self.popup.id);
		

		self.lockBody(false);
	}

	lockBody(lockIt) {
		lockIt ? $('body').addClass('locked') : $('body').removeClass('locked');
	}

	populateContent(title, content) {
		const self = this;

		const titleEl = self.popup.el.find('[data-title]');
		const contentEl = self.popup.el.find('[data-content]')

		if (content !== null) {
			self.popup.content = content;
		}

		if (title !== null) {
			self.popup.title = title;
		}

		contentEl.html(self.popup.content);
		titleEl.html(self.popup.title);

		self.popup.el.addClass('contentLoaded');

		$(document).trigger('core:popup:content:loaded');
	}

	loadContent(id, cb) {
		const self = this;

		if (id !== null) {
			$.ajax({
				url: core.ajaxUrl,
				data: {
					action: id,
					popup_id: id
				},
				type: "POST",
				dataType: "html",
				success: function (html) {
					typeof cb === 'function' ? cb(html, self) : '';
				}
			})
		}
	}
}