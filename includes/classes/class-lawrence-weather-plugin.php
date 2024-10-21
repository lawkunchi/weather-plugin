<?php

if (!defined('ABSPATH')) exit;

class LawrenceWeatherPlugin {
    private $weather_service;
    public function __construct() {
        $this->weather_service = new WeatherAPIService();
        add_shortcode('lawrence_weather', [$this, 'display_weather_shortcode']);
        add_shortcode('lawrence_weather_with_dropdown', [$this, 'display_weather_with_dropdown_shortcode']);
    }

    public function display_weather_shortcode($atts) {
        $atts = shortcode_atts(['city' => 'London'], $atts, 'lawrence_weather');
        $city = sanitize_text_field($atts['city']);
        return $this->render_weather_output($city);
    }

    public function display_weather_with_dropdown_shortcode() {
        $cities = ['London', 'New York', 'Johannesburg', 'Paris'];
        $selected_city = isset($_GET['city']) ? sanitize_text_field($_GET['city']) : 'London';
        
        ob_start();
        echo '<form method="get" action="">';
        echo '<select name="city" onchange="this.form.submit()">';
        
        foreach ($cities as $city) {
            $selected = ($city === $selected_city) ? 'selected' : '';
            echo "<option value='{$city}' {$selected}>{$city}</option>";
        }
        
        echo '</select>';
        echo '</form>';

        echo $this->render_weather_output($selected_city);
        return ob_get_clean();
    }

    private function render_weather_output($city) {
        $weather_data = $this->weather_service->get_weather_data($city);

        if (!is_array($weather_data) || !isset($weather_data['main']['temp'])) {
            return '<p>' . esc_html__('Unable to retrieve weather data at this time.', 'lawrence-weather') . '</p>';
        }

        $output = '<div class="weather-info">';
        $output .= '<h3>Weather in ' . esc_html($weather_data['name']) . '</h3>';
        $output .= '<p>Temperature: ' . esc_html($weather_data['main']['temp']) . '°C</p>';
        $output .= '<p>Conditions: ' . esc_html($weather_data['weather'][0]['description']) . '</p>';
        $output .= '</div>';

        return $output;
    }
}
