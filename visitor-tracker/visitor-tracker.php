<?php
/*
Plugin Name: Visitor Tracker 
Description: Tracks visitors and logs their IP, user agent, and visit time.
Version: 1.0
Author: Your Name
*/

register_activation_hook(__FILE__, 'vt_create_table');

function vt_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'visitor_logs';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        ip_address VARCHAR(100),
        user_agent TEXT,
        visit_time DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

add_action('wp_loaded', 'vt_log_visitor');

function vt_log_visitor() {
    if (is_admin()) return;
    global $wpdb;
    $table_name = $wpdb->prefix . 'visitor_logs';
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $visit_time = current_time('mysql');

    $wpdb->insert($table_name, [
        'ip_address' => $ip,
        'user_agent' => $user_agent,
        'visit_time' => $visit_time
    ]);
}

add_action('admin_menu', 'vt_add_admin_menu');

function vt_add_admin_menu() {
    add_menu_page('Visitor Logs', 'Visitor Logs', 'manage_options', 'visitor-logs', 'vt_display_logs');
}

function vt_display_logs() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'visitor_logs';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY visit_time DESC LIMIT 100");

    echo '<div class="wrap"><h1>Visitor Logs</h1><table class="widefat"><tr><th>ID</th><th>IP Address</th><th>User Agent</th><th>Visit Time</th></tr>';
    foreach ($results as $row) {
        echo '<tr><td>' . $row->id . '</td><td>' . $row->ip_address . '</td><td>' . $row->user_agent . '</td><td>' . $row->visit_time . '</td></tr>';
    }
    echo '</table></div>';
}
