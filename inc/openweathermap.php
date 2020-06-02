<?php
/**
 * Functions for communicating with the Openweathermap API
 */

define('OWM_APP_ID', 'b7f6a4c736296c252ef8f51233222978');

 function owm_get_current_weather($city, $country) {

    //1. Get current weather from OpenWeatherMap
        $response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid=" . OWM_APP_ID);

        
    //2. Make sure we got a valid response
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return [
            'success' => false,
            'error' => wp_remote_retrieve_response_code($response), //404
            ];
        }
    //3. Parse response and pick out data we need
        
        $data = json_decode(wp_remote_retrieve_body($response)); 
        
    //4.Pick out data we need
        $current_weather = [];
        $current_weather['temperature'] = $data->main->temp;
        $current_weather['humidity'] = $data->main->humidity;
        $current_weather['city'] = $data->name;
        $current_weather['country'] = $data->sys->country;
        $current_weather['conditions'] = $data->weather;
        $current_weather['pressure'] = $data->main->pressure;
        $current_weather['deg'] = $data->wind->deg;
        // Return picked data to caller
    
            return [
                'success' => true,
                'data' => $current_weather,
            ];
    }

 

                    

                    
    
 