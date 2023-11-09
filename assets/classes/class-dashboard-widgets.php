<?php 


class Dashboard_Widgets{

    public function __construct()
    {
        // Add the function to the 'wp_dashboard_setup' action to make sure it executes after the theme.
        add_action( 'wp_dashboard_setup', array($this, 'lattice_user_data_export_widget') );
    }

     /**
     * Adds a custom dashboard widget that displays on the WordPress admin dashboard.
     *
     * @return void
     */
    public function lattice_user_data_export_widget() {
        wp_add_dashboard_widget( 
            'lattice-quiz-data-export',
            'Lattice User Data Export',
            array($this, 'render_lattice_user_data_export_widget')
        );
    }   

    /**
     * Callback function to render the contents of our custom dashboard widget.
     *
     * @return string HTML markup to be displayed in the widget.
     */
    public function render_lattice_user_data_export_widget() {
        $html = '';

        $html .= '<p>This widget will allow you to request a copy of all the user data in .xls or .csv format.</p>';
        $html .= '<br />';
        $html .= '<form data-ajax-form data-action="generate_user_quiz_data">
                    <div data-form-msg></div>
                    <select name="file_type" style="line-height: 2.15;">
                        <option value="">Select a File Type</option>
                        <option value="CSV">CSV (Most versatile)</option>
                        <option value="XLS">XLS (Specifically Excel)</option>
                    </select>
                    <button type="submit" class="button button-primary button-large">Generate File</button>
                  </form><br />
                  <h3>Current Export Files:</h3>
                  <hr />
                  <div class="" data-file-system>
                  <i class="fa fa-spin fa-spinner fa-fw"></i>
                  </div>';

        echo $html; 
    }
}