<?php

if (!defined('ABSPATH')) exit;

class WeatherSettingsPage {
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }
    
    public function add_settings_page() {
        add_options_page(
            'Lawrence Weather Plugin Settings',
            'Weather Plugin',
            'manage_options',
            'lawrence-weather-plugin',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting('lawrence_weather_plugin_options', 'lawrence_weather_api_key');
        add_settings_section('lawrence_weather_api_section', 'API Settings', null, 'lawrence-weather-plugin');
        add_settings_field(
            'lawrence_weather_api_key',
            'OpenWeather API Key',
            [$this, 'render_api_key_field'],
            'lawrence-weather-plugin',
            'lawrence_weather_api_section'
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Lawrence Weather Plugin Settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('lawrence_weather_plugin_options');
                do_settings_sections('lawrence-weather-plugin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_api_key_field() {
        $api_key = get_option('lawrence_weather_api_key');
        echo '<input type="text" name="lawrence_weather_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
    }
}
