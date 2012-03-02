<?php
/*
Plugin Name: Better Countdown
Plugin URI: http://philipjohn.co.uk
Description: Adds a widget, shortcode and template tag for adding a countdown anywhere in your site.
Version: 0.1
Author: Philip John
Author URI: http://philipjohn.co.uk
License: GPL2
*/

// Stop the file being called directly
if (!function_exists('add_action')){
	echo "Oh. Hello. I think you might be in the wrong place. There's nothing for you here.";
	exit;
}

// Detect the install location, set useful defines
if (!defined('BC_PLUGIN_DIR')){
	if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
		define('BC_LOCATION', 'mu-plugins');
		define('BC_PLUGIN_DIR', WPMU_PLUGIN_DIR . '/');
		define('BC_PLUGIN_URL', WPMU_PLUGIN_URL . '/');
	} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/better-countdown/' . basename(__FILE__))) {
		define('BC_LOCATION', 'subfolder-plugins');
		define('BC_PLUGIN_DIR', WP_PLUGIN_DIR . '/better-countdown/');
		define('BC_PLUGIN_URL', WP_PLUGIN_URL . '/better-countdown/');
	} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
		define('BC_LOCATION', 'plugins');
		define('BC_PLUGIN_DIR', WP_PLUGIN_DIR . '/');
		define('BC_PLUGIN_URL', WP_PLUGIN_URL . '/');
	} else {
		wp_die(__('There was an issue determining where Better Countdown is installed. Please reinstall.', 'mp'));
	}
}

/**
 * Initialising stuff
 */
function bc_init(){
	// register the countdown plugin JS
	wp_register_script('jquery-countdown', BC_PLUGIN_URL.'js/jquery.countdown.min.js', 'jquery-1-5-1');
	wp_register_script('jquery-1-5-1', 'https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js');
}
add_action('init', 'bc_init');

/**
 * Enqueue scripts
 */
function bc_enqueue_scripts(){
	wp_enqueue_script('jquery-1-5-1');
	wp_enqueue_script('jquery-countdown');
}
add_action('wp_enqueue_scripts', 'bc_enqueue_scripts');

/**
 * Return the finished HTML for the countdown
 */
function bc_countdown(){
	$html = '<script type="text/javascript">
(function ($) {
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
	$(\'#defaultCountdown\').countdown({until: austDay});
	$(\'#year\').text(austDay.getFullYear());
});
</script>';
	$html .= '<div id="defaultCountdown"></div>';
	return $html;
}

/**
 * Register the shortcode
 */
function bc_countdown_shortcode(){
	echo bc_countdown();
}
add_shortcode('countdown', 'bc_countdown_shortcode');

?>