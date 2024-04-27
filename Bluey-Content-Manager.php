<?php
/**
 * Plugin Name: Bluey Content Manager
 * Description: A custom content manager created for Bluey & Co. to help easily manage the content on the site
 * Version: 1.0.0
 * Author: Okky "Kyle"
 *
 * 
 */

 defined('ABSPATH') || die;

 class Bluey_Content_Manager{

    // Constructor
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'display_admin_page' ) );
        add_action( 'wp_enqueue_scripts', 'enqueue_script' );

        // Hook admin initialization to plugin activation
        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
    }

    // enque script and style
    public function enqueue_script(){
        wp_enqueue_script( 
            'plugin-script',
            plugin_dir_path( __FILE__ ) . 'script/script.js',
            array('jquery'),
            '1.0', 
            array(
                'in_footer' => true
        ));
        
        wp_enqueue_style( 
            'main-style',
            plugin_dir_path( __FILE__ ) . 'css/style.css'
        );
        
        wp_enqueue_style( 
            'admin-view-style',
            plugin_dir_path( __FILE__ ) . 'css/view.css'
        );
    }
     // add admin page
    public function display_admin_page(){
        add_menu_page( 
            'Bluey Content Manager', 
            'Bluey', 
            'manage_options', 
            'bluey_content_manager',
            '',
            'dashicons-admin-site', 
            10
        );
    }

    // Plugin activation
    public function plugin_activation() {
        // Initialize admin
        $this->display_admin_page();
        // enqueue script on activation
        $this->enqueue_script();

        if(!get_option( 'bluey_faqs_option')){
            $faqs_data = array(
                'faq' => array(),
                'show_in_home' => true 
            );

            add_option( 'bluey_faqs_option', $faqs_data)
        }

        if(!get_option('bluey_about_us_option')){
            $about_us_data = array(
                'about_us_full_content' => array(
                    'first_paragraph' => '',
                    'second_paragraph' => ''
                ),
                'about_us_shown_in_home' => ''
            );

            add_option( 'bluey_about_us_option', $about_us_data);
        }

        if(!get_option( 'bluey_contact_info_option')){
            $contact_info_data = array(
                'phone_num' => '',
                'email' => '',
                'instagram_data' => array(
                    'name' => ''
                    'link_to_profile' => ''
                )
            );

            add_option( 'bluey_contact_info_option', $contact_info_data);
        }
        flush_rewrite_rules();
    }
 }
// Initialize the plugin
new Bluey_Content_Manager();