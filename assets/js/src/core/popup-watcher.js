import Popup from './popup'; // eslint-disable-line no-unused-vars

/**
 * @package     Popup Watcher
 * @version     1.0
 * @author      Trevor Wagner
 */
 export default class PopupWatcher{
    constructor() {
        this.init();

		return this;
    }

    init() {
        this.setObservers();
    }

    setObservers() {
        const self = this;

        // Listen for clicks on [data-popup]
        $('[data-popup-trigger]').on('click', (e) => {
            e.preventDefault();

            const el = $(e.target);
            const popup = new Popup(
                $('[data-popup]'), 
                el.data('popupTrigger'), 
                el.data('popupTitle'), 
                el.data('popupContent')
            );

            $(document).trigger('core:popup:show');
        });
    }
}