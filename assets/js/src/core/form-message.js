/**
 * @package     FormMsg
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class FormMsg{
    constructor() {
        this.el = null;
        return this;
    }

    init(el){
        var self = this;

        if (el.length) {
            self.el = el;
            self.setObservers();
        }
    }

    setObservers(){
        var self = this;

        $(document).on('core:message:init', (e, data) => {
            self.init(data.formMessage);
        })

        $(document).on('core:message:show', (e, data) => {
            self.show(data);
        })

        $(document).on('core:message:hide', (e) => {
            self.hide();
        })

        if (self.el != null) {
            self.el.on('click', (e) => {
                self.hide();
            })
        }
    }

    show(data){
        var resp = data.resp;
        
        if ('message' in resp && resp.message !== null) {
            this.el.text(resp.message)
                    .addClass('active')
                    .addClass(resp.status ? 'success' : 'error');
        }
    }

    hide(){
        this.el.removeClass('active success error info').text('');
    }
}