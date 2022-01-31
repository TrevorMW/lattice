/**
 * @package     Progress
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class Progress{
    constructor(form) {
        this.form = null;
        this.progress = null;
        this.msg = '';
        
        this.init(form);

        return this;
    }

    init(form){
        var self = this;

        if (form.length > 0) {
            self.form = form;

            self.createProgressHTML(form);
            self.setObservers();
        }
    }

    setObservers(){
        var self = this;

        $(document).on('core:progress:show', (e, data) => {
            let msg = '';

            if(data && 'msg' in data){
                msg = data.msg;
            }

            self.show(msg);
        });

        $(document).on('core:progress:hide', (e) => {
            self.hide();
        });
    }

    createProgressHTML(el){
        if( el.length > 0 && el.find('[data-progress]').length <= 0 ){
            $(el).append('<div data-progress><div><i class="fa fa-spin fa-spinner fa-pulse fa-fw"></i><br /><div data-progess-msg></div></div></div>');

            this.progress = el.find('[data-progress]');
            this.msg = this.progress.find('[data-progress-msg]');
        }
    }

    show(msg){
        this.progress.addClass('active');
        this.msg.html(msg);
    }

    hide(){
        this.progress.removeClass('active');
        this.msg.html('');
    }
}