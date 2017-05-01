<?php

namespace dont_change_email;

if( !class_exists('dont_change_email\model') ) {

# Requires 
require_once(dirname(__FILE__).'/settings-page.php');
require_once(dirname(__FILE__).'/disable-email-field.php');

/**
 * Here is where the logic is coded
 * Class to don't allow certain users to change their email.
 */
class controller {

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
     * Object of the class Disable_Email_Field
     * @var Object of type Disable_Email_Field
     */
    protected $script_enqueer;

    /**
     * Object of Settings page
     * @var Object of type Settings_Page
     */
    protected $my_settings_page;

    /**
     * Error message to be shown when a user cheats to change the email.
     * @var string
     */
    protected $error_message;

    function __construct() {
        # Read who can not change its email
        $this->options_roles_CNCE = get_option('user_roles');

        # Init the Email fields disabler class
        $this->script_enqueer = new Disable_Email_Field($this->options_roles_CNCE,
                                                        array($this, 'current_user_can_edit_its_email'));

        $this->error_message =  __('You are not supposed to change your email!', DCE);

        if(is_admin())
            $this->my_settings_page = new Settings_Page($this->options_roles_CNCE);

        add_action('personal_options_update', 
            array( $this, 'user_profile_update_WPdashboard'), 1, 1);

        # Only enqueue the script if the woocommerce is active
        if(is_woocommerce_active())
            add_action('woocommerce_save_account_details_errors', 
                array( $this, 'user_profile_update_woocommerceDashboard'), 10, 2);
    }

    /**
     * Triggers when the user update its email in the woocomerse dashboard 
     * @param  WP_Error &$errors Errors to be shown
     * @param  WP_user &$user   User Email
     */
    public function user_profile_update_woocommerceDashboard(&$errors, &$user) {
        # If the current user CAN change its email... do nothing.
        if( $this->current_user_can_edit_its_email() )
            return;

        $new_email = $user->user_email;
        $old_email = get_user_by( 'id', $user->ID )->data->user_email;

        if( $new_email !== $old_email ) {
            $user->user_email = $old_email;
            $errors->add('cannot_change_email', $this->error_message);
        }
    }

    /**
     * Triggers when the user update its email in the WP dashboard
     * @param  int  $user_id
     *              The current user ID
     */
    public function user_profile_update_WPdashboard( $user_id ) {

        # If the current user can not do this... GET OUT OF HERE
        if ( !current_user_can('edit_user',$user_id) )
            return;

        # If the current user CAN change its email... do nothing.
        if( $this->current_user_can_edit_its_email() )
            return;

        # ------- Verify If the current user changes its email -------
    
        # The new email of the user
        $new_email = isset($_POST['email']) ? $_POST['email']:$_POST['account_email'];

        # Old Email of the user
        $old_email = get_user_by( 'id', $user_id )->data->user_email;

        # If the user change the email STOP everything
        if( $new_email !== $old_email )
            return wp_die($this->error_message);
    }

    /**
     * Determinate if the current user can change its email
     * @return Boolean
     * @example True - The current user CAN CHANGE its email
     *          False - The current user CAN NOT CHANGE its email
     */
    public function current_user_can_edit_its_email() {

        # Get the current user roles
        $current_user_roles = wp_get_current_user()->roles;

        foreach ($this->options_roles_CNCE as $role_ID => $value) {
            $is_it = in_array( $role_ID, $current_user_roles);

            if($is_it)
                return false;
        }

        return true;
    }

    /**
     * Options getter
     * @return Array
     */
    public function get_options() {
        return $this->options_roles_CNCE;
    }

}# End class

$controller = new controller();

}


/**
 * Check if WooCommerce is active
 * @return boolean True  - If the plugin IS active
 *                 False - If the plugin IS NOT active
 * @ref https://wordpress.stackexchange.com/questions/193907/how-to-check-if-a-plugin-woocommerce-is-active
 **/
function is_woocommerce_active()
{
    if ( 
    in_array( 
        'woocommerce/woocommerce.php', 
        apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
        ) 
    )
        return true;

    return false;
}