<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ns_ab_options()
{
	//COMMENTS
	
	add_option('ns-enable-ab', '');
	add_option('ns-redirect-ab', '');
	add_option('ns-redirect-ab-link', '');
	add_option('ns-ab-font-awesome', '');
	add_option('ns-ab-font-awesome-size', '');
	add_option('ns-ab-font-awesome-color', '');
	add_option('ns-ab-page-text', '');
}
register_activation_hook( __FILE__, 'ns_ab_options');

function ns_ab_register_options_group(){
	/*Field options*/
	//COMMENTS
	register_setting('ns_ab_options_group', 'ns-enable-ab'); 
	register_setting('ns_ab_options_group', 'ns-redirect-ab'); 
	register_setting('ns_ab_options_group', 'ns-redirect-ab-link'); 
	register_setting('ns_ab_options_group', 'ns-ab-font-awesome');
	register_setting('ns_ab_options_group', 'ns-ab-font-awesome-size');
	register_setting('ns_ab_options_group', 'ns-ab-font-awesome-color');
	register_setting('ns_ab_options_group', 'ns-ab-page-text');
}
add_action ('admin_init', 'ns_ab_register_options_group');

?>