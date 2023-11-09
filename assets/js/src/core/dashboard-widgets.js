/**
 * @package     FormMsg
 * @version     1.0
 * @author     Trevor Wagner
 */
 export default class DashboardWidgets{
    constructor() {

        return this;
    }

    init(el){
        self.setObservers();
    }

    setObservers(){
        var self = this;

        $(document).on('core:files:load', (e, data) => {
            self.loadFiles();
        })
    }

    loadFiles() {
        const self = this;
        const fileSysEl = $('[data-file-system]');
        
        $.ajax({
			method: 'POST',
			url: core.ajaxUrl,
            action: 'get_quiz_export_files',
            data: {
                'action': 'get_quiz_export_files'
            },
			success: (response) => {
                const resp = JSON.parse(response);
                if(resp.data.html){
                    fileSysEl.html(resp.data.html);
                }
			}
		});
    }
}