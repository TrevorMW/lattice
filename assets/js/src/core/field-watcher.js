
/**
 * @package     Field Watcher
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class FieldWatcher{
    constructor() {
        this.init();

		return this;
    }

    init() {
        this.setObservers();

        $(document).on('core:popup:content:loaded', () => {
            this.setObservers();
        });
    }

    setObservers() {
        const self = this;
        const passwordFieldViewer = $('[data-view-password]');
        
        if(passwordFieldViewer.length > 0){
            $('[data-view-password]').on('click', (e) => {
                e.preventDefault();

                const el    = $(e.target).closest('a').data('viewPassword');
                const input = $('#' + el);

                if( input.length > 0 ){

                    const inputType = input.attr('type');
                    const icon      = $(e.target);

                    if(!input.hasClass('showingPassword')){
                        input.addClass('showingPassword');
                        input.attr('type', 'text');
                        icon.addClass('fa-eye-slash');
                        icon.removeClass('fa-eye');
                    } else {
                        input.removeClass('showingPassword');
                        input.attr('type', 'password');
                        icon.addClass('fa-eye');
                        icon.removeClass('fa-eye-slash');
                    }
                }
            });
        }
    }
}