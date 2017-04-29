<?php

namespace dont_change_email;

/**
 * View part of the public
 * Here will be constructed the settings page
 */
class Settings_Page
{
    /**
     * Start up
     */
    public function __construct()
    {
        // create custom plugin settings menu
        add_action('admin_menu', 
            array($this,'create_settings_submenu') );
    }

    /**
     * Create the submenu in settings
     */
    public function create_settings_submenu()
    {
        add_options_page( __('Modify Email Policy', DCE), //$page_title
                          __('Modify Email Policy', DCE), // $menu_title
                          'manage_options', //capability
                          'modify_email_policy', // $menu_slug
                          array($this, 'render_settings_page') //callback
                          );

        //call register settings function
        add_action( 'admin_init', 
            array($this, 'register_dont_change_email_settings') );
    }

    public function render_settings_page()
    {
        $options = get_option('user_roles');
        ?>
        <div class="wrap">
            <h1><?= __("Modify Email policy", DCE) ?></h1>
            <h4><?= __("Select the roles that can not change their emails", DCE) ?> </h4>

            <form method="post" action="options.php">
                <?php 

                settings_fields( 'dont_change_email_settings_group' );
                do_settings_sections( 'dont_change_email_settings_group' ); 
                $roles = get_editable_roles();

                foreach ($roles as $rol_ID => $rol):
                    $is_current_role_checked = isset($options[$rol_ID]) ? 'checked=checked':'';
                ?>
                    <input  type="checkbox" 
                            name="user_roles[<?= $rol_ID ?>]"
                            <?= $is_current_role_checked ?>
                    > 
                    <?= $rol['name']?> <br>
                <?php                    
                endforeach;
                
                submit_button(); ?>

            </form>
        </div>

        <?php
    }

    /**
     * Register the options in this plugin
     */
    public function register_dont_change_email_settings()
    {
        //register our settings
        register_setting( 'dont_change_email_settings_group', 'user_roles' );
    }
}

if( is_admin() )
    $my_settings_page = new Settings_Page();