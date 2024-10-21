<?php
/*
Plugin Name: Lawrence Weather Plugin
Description: A custom plugin to fetch and display weather data from OpenWeather API.
Author: Lawrence
Version: 1.0
Text Domain: lawrence-weather
*/

if (!defined('ABSPATH')) exit;

define('LAWRENCE_WEATHER_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once LAWRENCE_WEATHER_PLUGIN_DIR . 'includes/init.php';

function lawrence_weather_plugin_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=lawrence-weather-plugin">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'lawrence_weather_plugin_settings_link');


register_deactivation_hook(__FILE__, 'lawrence_weather_plugin_deactivate');

function lawrence_weather_plugin_deactivate() {
    delete_option('lawrence_weather_api_key');
}