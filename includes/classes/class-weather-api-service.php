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

        $city = sanitize_text_field( $city );

        $cached_weather = get_transient( 'weather_' . $city );
        if ( false !== $cached_weather ) {
            return $cached_weather;
        }

        $api_url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->api_key}&units=metric";
        $response = wp_remote_get($api_url);

        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
            return __( 'Unable to retrieve weather data at this time.', 'lawrence-weather' );
        }

        $weather_data = json_decode( wp_remote_retrieve_body( $response ), true );
        set_transient( 'weather_' . $city, $weather_data, 600 ); 

        return $weather_data;
    }
}
