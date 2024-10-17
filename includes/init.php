<?php
if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'classes/class-lawrence-weather-plugin.php';
require_once plugin_dir_path(__FILE__) . 'classes/class-weather-api-service.php';
require_once plugin_dir_path(__FILE__) . 'classes/class-weather-settings-page.php';

function lawrence_weather_plugin_init() {
    new LawrenceWeatherPlugin();
    new WeatherSettingsPage();
}
add_action('plugins_loaded', 'lawrence_weather_plugin_init');
