<?php

namespace MailjetPlugin\Includes;

use MailjetPlugin\Includes\SettingsPages\SubscriptionOptionsSettings;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Mailjet
 * @subpackage Mailjet/includes
 * @author     Your Name <email@example.com>
 */
class MailjetSettings
{
    /**
     * custom option and settings
     *  IMPORTANT - add each setting here, in order to be processed by the WP Settings API
     */
    public function mailjet_settings_init()
    {
        // Redirect the user to the Dashboard if he already configured his initial settings
        $currentPage = $_REQUEST['page'];
        if ('mailjet_settings_page' == $currentPage && !empty(get_option('mailjet_apikey')) && !empty(get_option('mailjet_apisecret'))) {
            wp_redirect(admin_url('/admin.php?page=mailjet_dashboard_page'));
            exit;
        }
        // If defined some contact list settings the we skip that page
        if ('mailjet_initial_contact_lists_page' == $currentPage && get_option('settings_step') == 'initial_contact_lists_settings_step') {
            //wp_redirect(admin_url('/admin.php?page=mailjet_dashboard_page'));
            //exit;
        }

        $this->addMailjetActions();

        // register a new setting for "mailjet" page
        register_setting('mailjet_initial_settings_page', 'mailjet_apikey');
        register_setting('mailjet_initial_settings_page', 'mailjet_apisecret');
        register_setting('mailjet_initial_settings_page', 'settings_step');

        register_setting('mailjet_initial_contact_lists_page', 'activate_mailjet_sync');
        register_setting('mailjet_initial_contact_lists_page', 'mailjet_sync_list');
        register_setting('mailjet_initial_contact_lists_page', 'activate_mailjet_initial_sync');
        register_setting('mailjet_initial_contact_lists_page', 'create_contact_list_btn');
        register_setting('mailjet_initial_contact_lists_page', 'list_name');
        register_setting('mailjet_initial_contact_lists_page', 'settings_step');





        register_setting('mailjet_connect_account_page', 'mailjet_apikey');
        register_setting('mailjet_connect_account_page', 'mailjet_apisecret');
        register_setting('mailjet_connect_account_page', 'settings_step');

        register_setting('mailjet_sending_settings_page', 'mailjet_enabled');
        register_setting('mailjet_sending_settings_page', 'mailjet_from_name');
        register_setting('mailjet_sending_settings_page', 'mailjet_from_email');
        register_setting('mailjet_sending_settings_page', 'mailjet_port');
        register_setting('mailjet_sending_settings_page', 'mailjet_ssl');
        register_setting('mailjet_sending_settings_page', 'mailjet_from_email_extra');
        register_setting('mailjet_sending_settings_page', 'mailjet_from_email_extra_hidden');
        register_setting('mailjet_sending_settings_page', 'mailjet_test_address');
        register_setting('mailjet_sending_settings_page', 'send_test_email_btn');
        register_setting('mailjet_sending_settings_page', 'settings_step');

        register_setting('mailjet_subscription_options_page', 'activate_mailjet_sync');
        register_setting('mailjet_subscription_options_page', 'mailjet_sync_list');
        register_setting('mailjet_subscription_options_page', 'activate_mailjet_initial_sync');
        register_setting('mailjet_subscription_options_page', 'activate_mailjet_comment_authors_sync');
        register_setting('mailjet_subscription_options_page', 'mailjet_comment_authors_list');
        register_setting('mailjet_subscription_options_page', 'settings_step');

        register_setting('mailjet_user_access_page', 'mailjet_access_administrator');
        register_setting('mailjet_user_access_page', 'mailjet_access_editor');
        register_setting('mailjet_user_access_page', 'mailjet_access_author');
        register_setting('mailjet_user_access_page', 'mailjet_access_contributor');
        register_setting('mailjet_user_access_page', 'mailjet_access_subscriber');
        register_setting('mailjet_user_access_page', 'settings_step');


    }


    /**
     * Adding a Mailjet logic and functionality to some WP actions - for example - inserting checkboxes for subscription
     */
    private function addMailjetActions()
    {
        if (!empty(get_option('activate_mailjet_sync')) && !empty(get_option('mailjet_sync_list'))) {

            $subscriptionOptionsSettings = new SubscriptionOptionsSettings();
            add_action('show_user_profile', array($subscriptionOptionsSettings, 'mailjet_show_extra_profile_fields'));
            add_action('edit_user_profile', array($subscriptionOptionsSettings, 'mailjet_show_extra_profile_fields'));
            add_action('register_form', array($subscriptionOptionsSettings, 'mailjet_show_extra_profile_fields'));
            add_action('user_new_form', array($subscriptionOptionsSettings, 'mailjet_show_extra_profile_fields'));

            add_action('personal_options_update', array($subscriptionOptionsSettings, 'mailjet_my_save_extra_profile_fields'));
            add_action('edit_user_profile_update', array($subscriptionOptionsSettings, 'mailjet_my_save_extra_profile_fields'));

            add_action('user_register', array($this, array($subscriptionOptionsSettings, 'mailjet_register_extra_fields')));
        }


        /* Add custom field to comment form and process it on form submit */
        if (!empty(get_option('activate_mailjet_comment_authors_sync')) && !empty(get_option('mailjet_comment_authors_list'))) {
            add_action('comment_form_after_fields', array($subscriptionOptionsSettings, 'mailjet_show_extra_comment_fields'));
            add_action('wp_insert_comment',array($subscriptionOptionsSettings, 'mailjet_subscribe_comment_author'));


            if (!empty($_GET['mj_sub_comment_author_token'])
                &&
                $_GET['mj_sub_comment_author_token'] == sha1($_GET['subscribe'] . str_ireplace(' ', '+', $_GET['user_email']))) {
                $subscriptionOptionsSettings->mailjet_subscribe_unsub_comment_author_to_list($_GET['subscribe'], str_ireplace(' ', '+', $_GET['user_email']));
            }
        }

    }

}