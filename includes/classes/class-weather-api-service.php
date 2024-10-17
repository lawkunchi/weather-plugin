<?php

if (!defined('ABSPATH')) exit;

class WeatherApiService {
    
    private $api_key;
    
    public function __construct() {
        $this->api_key = get_option('lawrence_weather_api_key');
    }
    
    public function get_weather_data($city) {
        if (empty($this->api_key)) {
            return false;
        }

        $api_url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->api_key}&units=metric";
        $response = wp_remote_get($api_url);

        if (is_wp_error($response)) {
            return false;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        if ($data['cod'] != 200) {
            return false;
        }

        return $data;
    }
}
