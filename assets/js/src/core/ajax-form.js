/**
 * @package     AjaxForm
 * @version     1.0
 * @author     Trevor Wagner
 */
export default class AjaxForm{
  constructor() {
    this.form = {
      el: null,
      action: null,
      confirm: false,
      submit: null,
      url: null
    };

    this.data = { formData: null };
    this.flags = { canSubmit: false };

    return this;
  }

  init(form, url) {
    if (form.length > 0) {
      this.form.el = form;
      this.form.submit = form.find('button[type="submit"]');
      this.form.action = form.data('action');
      this.form.url = url;

      if (form.data('confirm') !== undefined) {
        this.form.confirm = form.data('confirm');
      }
    }

    this.collectData();

    if (this.confirmFormRequest()) {
      this.makeRequest(this);
    } else {
      $(document).trigger('core:loader:hide');
    }
  }

  setObservers(){
    var self = this;

    $('[data-ajax-form]').on('submit', (e) => {
      e.preventDefault();

      var form    = $(e.currentTarget),
          formMsg = form.find('[data-form-msg]');
    
      if(formMsg.length > 0){          
        $(document).trigger('core:message:init', { formMessage: formMsg }).trigger('core:message:hide');
      }

      self.init(form, core.ajaxUrl);
    });
  }

  collectData(){
    this.data.formData = this.form.el.serialize();
  }

  confirmFormRequest(){
    return this.form.confirm !== false ? confirm(this.form.confirm) : true;
  }

  makeRequest(){
    $(document).trigger('core:overlay:show');

    // Ajax POST call using native DW library.
    $.ajax({
      method: 'POST',
      action: this.form.action,
      url: this.form.url,
      data: this.data.formData + '&action=' + this.form.action,
      success: (resp) => {
        this.formSuccess(resp);
      }
    });
  }

  formSuccess(resp){
    var response;

    $(document).trigger('core:overlay:hide');
    
    try {
      response = JSON.parse(resp);
      
      $(document).trigger('core:message:show', { resp: response });

      if(response.status && response.pageRefresh){
        if(response.redirectURL !== null){
          window.location = response.redirectURL;
        } else {
          location.reload();
        }
      }
    } catch (e) {
      
    }
  }
}



