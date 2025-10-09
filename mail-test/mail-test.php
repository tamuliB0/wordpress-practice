<?php

/* 
Plugin name: Plugin status notifier
Description: Send a email when a plugin is activated/deactivated 
Version: 1.0 
Author: ABC 
*/


register_activation_hook(__FILE__, 'mail_plugin_activate');

register_deactivation_hook(__FILE__, 'mail_plugin_deactivate');



function mail_plugin_activate() {
    $email = get_option('admin_email');
    $subject = 'Plugin activated';
    $message = "Hello,".esc_html($email)." a mail plugin has been activated on your wordpress site" ;
    wp_mail($email, $subject, $message);
}

function mail_plugin_deactivate() {
    $email = get_option('admin_email');
    $subject = 'Plugin deactivated';
    $message = "Hello,".esc_html($email)." mail plugin has been deactivated on your wordpress site" ;
    wp_mail($email, $subject, $message);
}


