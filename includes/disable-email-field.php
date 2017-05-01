<?php

namespace dont_change_email;

/**
 * Enqueue the scripts to disable each email field needed...
 * - On the admin page
 * - On Woocommerse dashboard page 
 */
class Disable_Email_Field {

	/**
     * The user roles that can not change their email
     * @var Array 
     * @example  Array
     *           (
     *               [administrator] => on
     *               [editor] => on
     *               [contributor] => on
     *           )
     */
    protected $options_roles_CNCE;

    /**
     * Determinate if the current user can change its email
     * @var  Callback
     * @return Boolean
     * @example True - The current user CAN CHANGE its email
     *          False - The current user CAN NOT CHANGE its email
     */
    protected $current_user_can_edit_its_email;

	function __construct($options_roles_CNCE, $current_user_can_edit_its_email) {

        $this->options_roles_CNCE = $options_roles_CNCE;
        $this->current_user_can_edit_its_email = $current_user_can_edit_its_email;

		add_action('admin_enqueue_scripts', 
			array($this, 'enqueueScrp_disable_field_in_WPdashboard'));

	}

	public function enqueueScrp_disable_field_in_WPdashboard() {

        global $current_screen;

        if($current_screen->id !== 'profile')
            return;

        # If the current user CAN change its email... do nothing.
        if( call_user_func( $this->current_user_can_edit_its_email ) )
            return;

		wp_enqueue_script( 'handle_name', 
						   DCE_PLUGIN_URL.'/js/disable_email_field_wpdashboard.js', 
						   array('jquery'), 
						   '0.0',
						   false);

        # Apply i18n to the message shown.
        wp_localize_script( 'handle_name', 
                            'message_not_able_change_email', 
                            __("Emails can not be changed",DCE));
	}


}# End class