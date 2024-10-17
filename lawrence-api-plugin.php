<?php
/*
Plugin Name: Lawrence Weather Plugin
Description: A custom plugin to fetch and display weather data from OpenWeather API.
Author: Lawrence
Version: 1.0
*/

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/init.php';


function lawrence_weather_plugin_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=lawrence-weather-plugin">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'lawrence_weather_plugin_settings_link');
