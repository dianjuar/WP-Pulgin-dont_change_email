<?php

namespace dont_change_email;

if( !class_exists('dont_change_email\model') ) {

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

    function __construct() {
        # Read who can not change its email
        $this->options_roles_CNCE = get_option('user_roles');

        add_action('personal_options_update', 
            array( $this, 'user_profile_update'), 1, 1);
    }

    /**
     * Triggers when the user update its profile
     * @param  int  $user_id
     *              The current user ID
     */
    public function user_profile_update( $user_id ) {
        // If the current user can not do this... GET OUT OF HERE
        if ( !current_user_can('edit_user',$user_id) )
            return;

        # The new email of the user
        $new_email = $_POST['email'];

        # Old Email of the user
        $old_email = get_user_by( 'id', $user_id )->data->user_email;

        # If the user change the email STOP everything
        if( $new_email !== $old_email )
            return wp_die( __('<h1>You are Cheating!!!!</h1> We are calling the Internet Police right NOW!', DCE) );
    }

    /**
     * Options getter
     * @return Array
     */
    public function get_options()
    {
        return $this->options_roles_CNCE;
    }

}# End class

$controller = new controller();

require_once(dirname(__FILE__).'/settings-page.php');

if( is_admin() )
    $my_settings_page = new Settings_Page($controller->get_options());

}