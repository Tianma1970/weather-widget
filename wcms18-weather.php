<?php
/**
 * Plugin Name: WCMS18 Weather Widget
 * Plugin URI:  https://thehiveresistance.com/wcms18-starwars
 * Description: This plugin for displaying the current Weather for a location
 * Version:     0.1
 * Author:      Tillmann Weimer
 * Author URI:  https://remlost.eu/retro
 * License:     WTFPL
 * License URI: http://www.wtfpl.net/
 * Text Domain: wcms18-weather
 * Domain Path: /languages
 */

require("inc/openweathermap.php");
require("inc/class.weatherWidget.php");

function w18ww_widgets_init() {
	register_widget('weatherWidget');
}
add_action('widgets_init', 'w18ww_widgets_init');

function w18ww_enqueue_style() {
	wp_enqueue_style('wcms18-weather', plugin_dir_url(__FILE__) . 'assets/css/wcms18-weather.css');

	wp_enqueue_script('wcms18-weather-js', plugin_dir_url(__FILE__) . 'assets/js/wcms18-weather.js', ['jquery'], false, true);
	wp_localize_script('wcms18-weather-js', 'wcms18_weather_settings', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'w18ww_enqueue_style');
/**
 * Respond to Ajax request for get current weather
 */
function w18ww_ajax_get_current_weather() {
	$current_weather_request = owm_get_current_weather($_POST['city'], $_POST['country']);

	if($current_weather_request['success']) {
		wp_send_json_success($current_weather_request['data']);
	} else {
		wp_send_json_error($current_weather_request['error']);
	}

	//wp_send_json($current_weather);
	

}
add_action('wp_ajax_get_current_weather', 'w18ww_ajax_get_current_weather');
add_action('wp_ajax_nopriv_get_current_weather', 'w18ww_ajax_get_current_weather');