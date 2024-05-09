<?php
/*
Plugin Name: Admin Notice Extended
Plugin URI: https://example.com/custom-database-plugin
Description: A plugin to demonstrate WordPress database operations using OOP approach.
Version: 1.0
Author: Your Name
Author URI: https://example.com
*/

class an_admin_notice{
    
    public function __construct(){
        add_action("init", array($this,"init"));
    }

    public function init(){
        add_action("admin_notices", array($this,"add_notice"));
        add_action("admin_enqueue_scripts", array($this,"ajax_call"));
        add_action("wp_ajax_dissable", array($this,"dissable"));
    }

    public function dissable(){
        check_ajax_referer("dissable");

		update_option('admin_notice_dismiss', true);
    }
    public function add_notice(){
        $current_screen=get_current_screen();
        $is_dismissed = get_option('admin_notice_dismiss', false);
        if($current_screen->id=="plugins" && !$is_dismissed){
            echo "<div class= 'notice notice-success is-dismissible custom-notice' ><p>Here is your Notice </p></div>";
        }
        
    }

    public function ajax_call(){
        $admin_ajax_url=admin_url("admin-ajax.php");
        $ajax_nonce=wp_create_nonce("dissable");
        $ajax_url=plugin_dir_url(__FILE__);
        wp_enqueue_script("ajax_handle", $ajax_url ."js/ajax.js", array() ,"1.0", true);
        wp_localize_script("ajax_handle","admin_ajax", array(
            "admin_url"=> $admin_ajax_url,
            "nonce"=> $ajax_nonce
        )) ;
    }
}

new an_admin_notice();