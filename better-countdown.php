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
	wp_register_script('jquery-lwtCountdown-1.0', BC_PLUGIN_URL.'js/jquery.lwtCountdown-1.0.js', 'jquery');
	wp_register_script('jquery-lwtCountdown-misc', BC_PLUGIN_URL.'js/misc.js', 'jquery-lwtCountdown-1.0');
}
add_action('init', 'bc_init');

/**
 * Enqueue scripts
 */
function bc_enqueue_scripts(){
	// Enqueue jQuery and countdown
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-lwtCountdown-1.0');
	wp_enqueue_script('jquery-lwtCountdown-misc');
	
	// Enqueue styles for countdown
	$myStyleUrl = plugins_url('css/main.css', __FILE__); // Respects SSL, main.css is relative to the current file
	wp_register_style('jquery-countdown', $myStyleUrl);
	wp_enqueue_style('jquery-countdown');
}
add_action('wp_enqueue_scripts', 'bc_enqueue_scripts');

/**
 * Return the finished HTML for the countdown
 */
function bc_countdown_r($args){
	// Define the array of defaults
	$defaults = array(
		'date' => '2012-06-05 12:05:42'
	);
	$args = wp_parse_args( $args, $defaults ); // merge defaults with passed values
	extract( $args, EXTR_SKIP ); // give each arg it's own variable

	// convert time to timestamp, then generate nice time
	$date = date_parse(date('Y-m-d H:i:s', strtotime($date)));
	
	$html = '<!-- Countdown dashboard start -->
		<div id="countdown_dashboard">
			<div class="dash weeks_dash">
				<span class="dash_title">weeks</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash days_dash">
				<span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

		</div>
		<!-- Countdown dashboard end -->';
	$html .= '<script language="javascript" type="text/javascript">
			try{
				jQuery.noConflict();
			} catch(e){};
				jQuery(\'#countdown_dashboard\').countDown({
					targetDate: {
						\'day\': 		'.$date['day'].',
						\'month\': 	'.$date['month'].',
						\'year\': 	'.$date['year'].',
						\'hour\': 	'.$date['hour'].',
						\'min\': 		'.$date['minute'].',
						\'sec\': 		'.$date['second'].'
					}
				});
		</script>';
	return $html;
}

/**
 * Register the shortcode; also acts as a template tag
 */
function bc_countdown($atts){
	// extract the attributes, setting defaults if necessary
	extract( shortcode_atts( array(
		'date' => '2012-05-03'
	), $atts ) );
	
	echo bc_countdown_r($atts);
}
add_shortcode('countdown', 'bc_countdown');

?>