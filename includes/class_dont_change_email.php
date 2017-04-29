<?php

if( !class_exists('dont_change_email') ) {

/**
 * Class to don't allow certain users to change their email.
 */
class dont_change_email {

    function __construct() {

        /**
         * 
         */
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

}# End class

$dont_change_email = new dont_change_email();

}