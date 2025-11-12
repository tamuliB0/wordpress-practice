<?php
/* 
Plugin Name: Weather-api
Description: Displays weather information using shortcode 
Author: ABC
Version: 1.0
*/
function show_weather($atts) {
    $atts = shortcode_atts(
        array
        ('location' => 'India'
    ), $atts);

    $base_url = "https://api.weatherapi.com/v1/current.json?key=";
    $api_key = "bfa525ddbbb2465f8d0134248251011";
    $query = $atts['location'];


    $response = wp_remote_get($base_url.$api_key."&q=".$query);
    $body = wp_remote_retrieve_body($response);
    $details = json_decode($body, true);

    $output = '<div class = "weather-info">';

    $output =  $output."<h3>Weather details for ".$query."</h3>";

    $output = $output. $details["current"]["last_updated"]."<br>"."<br>";
    $output = $output. "<p>Temperature: ".$details["current"]["temp_c"]." 'C</p>";
    $output = $output. "<p>Condition: ".$details["current"]["condition"]["text"]."</p>";
    $output = $output. "<p>Wind Speed: ".$details["current"]["wind_mph"]." mph</p>";
    $output = $output. "<p>Humidity: ".$details["current"]["humidity"]." %</p>";

    $output = $output.'</div>';

    return $output;

}

 add_shortcode('weather', 'show_weather');