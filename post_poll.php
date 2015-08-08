<?php 
/*
Plugin Name: Postpoll
Plugin URI: 
Description: Make a poll of your own posts and see which one People Likes
Version: 0.1.3
Author: Eric Zeidan
Author URI: 
License: GPL2
*/

/*  Copyright 2015 Eric Zeidan  (email : k2klettern@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// load language files

add_action('plugins_loaded', 'postpoll_text');

function postpoll_text() {
    load_plugin_textdomain('postpoll', false, basename(dirname(__FILE__)) . '/langs');
}

// Make sure we don't expose any info if called directly



if ( !function_exists( 'add_action' ) ) {
	_e('Hi there!  I\'m just a plugin, not much I can do when called directly.','postpoll');
	exit;
}

require_once('libppl/functions.php');

register_activation_hook(__FILE__, 'postpoll_plugin_activate');
add_action('admin_init', 'postpoll_plugin_redirect');

global $postpoll_db_version;
$postpoll_db_version = '1.0';

function postpoll_install() {
    global $wpdb;
    global $postpoll_db_version;

    $table_name = $wpdb->prefix . 'postpoll';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name varchar(200) NOT NULL,
        email varchar(200) NOT NULL,
        address varchar(200) NOT NULL,
        comments varchar(800) NOT NULL,
        pollid varchar(30) NOT NULL,
        postsvoted varchar (200) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

register_activation_hook( __FILE__, 'postpoll_install' );

function postpoll_plugin_activate() {
add_option('postpoll_plugin_do_activation_redirect', true);
}

function postpoll_plugin_redirect() {
if (get_option('postpoll_plugin_do_activation_redirect', false)) {
    delete_option('postpoll_plugin_do_activation_redirect');
    if(!isset($_GET['activate-multi']))
    {
        wp_redirect("admin.php?page=Postpoll-plugin");
    }
 }
}

add_action('admin_init', 'postpoll_admin_init' );

function postpoll_admin_init() {
        wp_register_script( 'postpoll-script', plugins_url( '/libppl/script.js', __FILE__ ) );
        wp_enqueue_script("jquery");
        wp_enqueue_script( 'postpoll-script' );
}

function shortcode_pplbutton($atts) {
        ob_start();
        include('postpoll_show.php');
        $output_string=ob_get_contents();;
        ob_end_clean();

        return $output_string;
} 

add_shortcode('postpollshow', 'shortcode_pplbutton');

add_action('admin_menu', 'postpoll_setup_menu');
 
function postpoll_setup_menu(){
        add_menu_page( 'Postpoll Plugin Page', 'Postpoll Plugin', 'manage_options', 'Postpoll-plugin', 'postpoll_init' );
        add_submenu_page( 'Postpoll-plugin', 'Postpoll Plugin Report', 'Edit polls', 'manage_options', 'Postpoll-edit', 'postpoll_edit');
        add_submenu_page( 'Postpoll-plugin', 'Postpoll Plugin Report', 'Report polls', 'manage_options', 'Postpoll-report', 'postpoll_report');
}

 
function postpoll_init(){

        include('postpoll_init.php');
			        	
} //end function postpoll_init

function postpoll_edit() {

        include('postpoll_edit.php');

} // end function postpoll_edit

function postpoll_report() {
        include('postpoll_report.php');
} // end function postpoll_report
?>