/**
 * @package     FormMsg
 * @version     1.0
 * @author     Trevor Wagner
 */
 export default class DashboardWidgets{
    constructor() {

        this.init();

        return this;
    }

    init(){
        this.setObservers();
    }

    setObservers(){
        var self = this;

        $(document).on('core:files:load', () => {
            const fileSysEl = $('[data-file-system]');
            fileSysEl.find('table').hide();
            fileSysEl.find('i.fa').show();
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

                $(document).trigger('core:progress:hide');

                if(resp.data.html){
                    fileSysEl.find('i.fa').hide();
                    fileSysEl.show();
                    fileSysEl.html(resp.data.html);
                }
			}
		});
    }
}