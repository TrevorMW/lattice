import AjaxFormWatcher from './core/ajax-form-watcher';
import DashboardWidgets from './core/dashboard-widgets';

(() => {
	'use strict';

	$(document).ready(() => {
		new AjaxFormWatcher();
        const dashWidgets = new DashboardWidgets();
        dashWidgets.loadFiles();
	});
})();
