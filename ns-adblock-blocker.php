<?php
/*
Plugin Name: NS AdBlock Blocker
Description: This plugin allows you to lock site display to users with adBlockers installed
Version: 1.1.0
Author: NsThemes
Author URI: http://www.nsthemes.com
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ns-adblock-blocker-ads
Domain Path: /i18n
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** 
 * @author        PluginEye
 * @copyright     Copyright (c) 2019, PluginEye.
 * @version       1.1.1
 * @license       https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 * PLUGINEYE SDK
*/

require_once('plugineye/plugineye-class.php');
$plugineye = array(
    'main_directory_name'       => 'ns-adblock-blocker',
    'main_file_name'            => 'ns-adblock-blocker.php',
    'redirect_after_confirm'    => 'admin.php?page=ns-adblock-blocker%2Fns-admin-options%2Fns_admin_option_dashboard.php',
    'plugin_id'                 => '420',
    'plugin_token'              => 'NWQyNzBhYTcxZDZiYjJhNGRlYzc4MDhhMDkwNzU3MjNlYmFiMjUzODc0MTJiZjVhMjc0NmE0YTJiODRjOTk4MDI3MDEzYzFmNzgwMTQ=',
    'plugin_dir_url'            => plugin_dir_url(__FILE__),
    'plugin_dir_path'           => plugin_dir_path(__FILE__)
);

$plugineyeobj420 = new pluginEye($plugineye);
$plugineyeobj420->pluginEyeStart();      

require_once( plugin_dir_path( __FILE__ ).'class/class-plugin-theme-review-request.php');

require_once( plugin_dir_path( __FILE__ ).'ns-adblock-blocker-options.php');
require_once( plugin_dir_path( __FILE__ ).'ns-admin-options/ns-admin-options-setup.php');

/*========================================================*/
//  frontend CSS.			          
/*========================================================*/
function ns_ab_css( $hook ) { 
    wp_enqueue_style('ns-ab-style-custom', plugin_dir_url( __FILE__ ). '/assets/css/style.css');
    wp_enqueue_style( 'all-min', plugin_dir_url( __FILE__ ). '/assets/css/all.min.css', array(), '1.0.0' ); 
}   
add_action( 'wp_enqueue_scripts', 'ns_ab_css' );

/*========================================================*/
//  frontend JS: 	          
/*========================================================*/
function ns_ab_js( $hook ) {
    $is_enabled = get_option('ns-enable-ab', false);
    if($is_enabled == 'on')
        $is_enabled = true;
    if($is_enabled){
        wp_enqueue_script( 'ns-smart-js', plugin_dir_url( __FILE__ ). 'assets/js/ads.js', array(), '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'ns_ab_js' );


add_action( 'admin_enqueue_scripts', 'ab_backend_scripts');
if ( ! function_exists( 'ab_backend_scripts' ) ){
    function ab_backend_scripts($hook) {
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
    }
}


function ns_ab_create_new_page(){
    $page_exists = get_option('ns_ab_page', -1);
    $redirect_type = get_option('ns-redirect-ab', '');
    //if( !$page_exists &&  get_post_status($page_exists) != 'publish'){
    if( get_post_status($page_exists) != 'publish' && $redirect_type != 'custom'){
        $new_post = array(
                'post_title'      => 'Ads Block Enabled',
                'post_content'    => '[ns-ab-page]',
                'post_status'     => 'publish',
                'post_date'       => date('Y-m-d H:i:s'),
                'post_author'     => get_current_user_id(),
                'post_type'       => 'page'
            );
        $post_id = wp_insert_post($new_post);
        update_option('ns_ab_page', $post_id);
   }
}
add_action('init','ns_ab_create_new_page');


function ns_ab_print_script(){
    $is_enabled = get_option('ns-enable-ab', false);
    if($is_enabled == 'on')
        $is_enabled = true;
    if(!is_admin() && ! is_login_page() && $is_enabled && !isset($_GET['adBlockDetected'])){
        $redirect_url = ns_ab_get_redirect_url();
        update_option('abb_total_open_count', get_option( 'abb_total_open_count', 0 )+1);
        echo "
            <script>
                window.onload = function() {
                    if( window.canRunAds === undefined ){
                        // adblocker detected, show fallback
                        window.location = '$redirect_url?adBlockDetected';
                    }
                }
            </script>
        ";
    }
}
add_action('init','ns_ab_print_script');

function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/*========================================================*/
//  SHORTCODE: [ns-ab-page]
/*========================================================*/
function ns_ab_shortcode_page( $atts ){
    if(!is_admin()){
        require_once( plugin_dir_path( __FILE__ ).'ns-adblock-blocker-page.php');
    }
}
add_shortcode( 'ns-ab-page', 'ns_ab_shortcode_page' );


function ns_ab_get_redirect_url(){
    $redirect_type = get_option('ns-redirect-ab', '');
    $default_page_id = get_option('ns_ab_page');
    $redirect_link = get_permalink($default_page_id);
    if($redirect_type == 'custom')
        $redirect_link = get_option('ns-redirect-ab-link', $redirect_link);
    return $redirect_link;
}

?>