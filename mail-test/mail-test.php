<?php
/* 
Plugin name: Plugin status notifier
Description: Send a email when a plugin is activated/deactivated 
Version: 1.0 
Author: ABC 
*/

add_action('activated_plugin', 'activation_mail');

function activation_mail($plugin) {
    $email = get_option('admin_email');
    $subject = 'Plugin activated';
    $message = "The plugin ". basename($plugin). " is activated." ;
    wp_mail($email, $subject, $message);
}

add_action('deactivated_plugin', 'deactivation_mail');

function deactivation_mail($plugin) {
    $email = get_option('admin_email');
    $subject = 'Plugin deactivated';
    $message = "The plugin ". basename($plugin). " is deactivated." ;
    wp_mail($email, $subject, $message);
}

