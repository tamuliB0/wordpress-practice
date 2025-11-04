<?php

/* 
Plugin name: Github repo
Description: A hyperlink to github repository page
Author: ABC
Version: 1.0 
*/

function github_shortcode($atts){
    $atts = shortcode_atts(
        array(
            'user' => 'tamuliB0',
        ),
        $atts,
        'github_shortcode'
    );

    $username = ($atts['user']);
    
    $url = 'https://api.github.com/users/'. $username . '/repos';
    $response = wp_remote_get($url);
    $body = wp_remote_retrieve_body($response);
    $repos = json_decode($body, true);

    $output = "<div> Repositories of user " . ($username);
    $output = $output ."<ul>";

        foreach ($repos as $repo) {
            $output = $output . '<li>' . $repo['full_name'] . "</li>"; 
        }
    $output = $output . "</ul>";
    $output = $output . "</div>";

    return $output;
    
}

add_shortcode('repo', 'github_shortcode');


