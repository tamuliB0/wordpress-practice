<?php
/*
Plugin Name: Contact Form 
Description: Saves user information in the database
Author: Name
Version: 1.0
*/

register_activation_hook(__FILE__, 'my_contact_plugin_activate');
function my_contact_plugin_activate() {
    global $wpdb;
    add_option('my_contact_plugin_thank_you_message', 'Thank you for your message!', '', 'no');
    $table_name = $wpdb->prefix . 'my_contact_form_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        contact_name varchar(255) NOT NULL,
        contact_email varchar(255) NOT NULL,
        contact_message text NOT NULL,
        submission_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('admin_menu', 'my_contact_plugin_menu');
function my_contact_plugin_menu() {
    add_options_page('My Contact Form Settings', 'Contact Form', 'manage_options', 'my-contact-plugin', 'my_contact_plugin_settings_page');
}

add_action('admin_init', 'my_contact_plugin_settings_init');
function my_contact_plugin_settings_init() {
    register_setting('my_contact_plugin_group', 'my_contact_plugin_thank_you_message');
    add_settings_section('my_contact_plugin_main_section', 'Form Settings', null, 'my-contact-plugin');
    add_settings_field('thank_you_message_field', 'Thank You Message', 'my_contact_plugin_thank_you_message_callback', 'my-contact-plugin', 'my_contact_plugin_main_section');
}

function my_contact_plugin_thank_you_message_callback() {
    $message = get_option('my_contact_plugin_thank_you_message');
    echo '<input type="text" name="my_contact_plugin_thank_you_message" value="' . $message . '" class="regular-text">';
}

function my_contact_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>My Contact Form Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('my_contact_plugin_group');
            do_settings_sections('my-contact-plugin');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

add_shortcode('my_contact_form', 'my_contact_form_shortcode');
function my_contact_form_shortcode() {
    global $wpdb;
    ob_start();
    if (isset($_POST['my_contact_form_submit'])) {
        $name = $_POST['contact_name'];
        $email = $_POST['contact_email'];
        $message = $_POST['contact_message'];
        if (empty($name) || empty($email) || empty($message)) {
            echo '<div>Please fill out all fields.</div>';
        } else {
            $table_name = $wpdb->prefix . 'my_contact_form_submissions';
            $wpdb->insert($table_name, [
                'contact_name' => $name,
                'contact_email' => $email,
                'contact_message' => $message,
                'submission_date' => current_time('mysql')
            ]);
            $to_user = $email;
            $subject_user = "Thank you for contacting us!";
            $body_user = "Hello " . $name . ",\n\nWe have received your message and will reply soon.\n\nYour message:\n" . $message . "\n\nBest regards,\nSite Team";
            $headers_user = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $to_user);
            wp_mail($to_user, $subject_user, $body_user, $headers_user);
            $thank_you_message = get_option('my_contact_plugin_thank_you_message');
            echo '<div>' . $thank_you_message . '</div>';
        }
    }
    ?>
    <form method="post">
        <p>
            <label for="contact_name">Name:</label><br>
            <input type="text" id="contact_name" name="contact_name" value="<?php echo isset($name) ? $name : ''; ?>">
        </p>
        <p>
            <label for="contact_email">Email:</label><br>
            <input type="email" id="contact_email" name="contact_email" value="<?php echo isset($email) ? $email : ''; ?>">
        </p>
        <p>
            <label for="contact_message">Message:</label><br>
            <textarea id="contact_message" name="contact_message"><?php echo isset($message) ? $message : ''; ?></textarea>
        </p>
        <p>
            <input type="submit" name="my_contact_form_submit" value="Submit">
        </p>
    </form>
    <?php
    return ob_get_clean();
}

add_action('admin_menu', 'my_contact_plugin_submissions_menu');
function my_contact_plugin_submissions_menu() {
    add_menu_page('Form Submissions', 'Submissions', 'manage_options', 'my-contact-plugin-submissions', 'my_contact_plugin_submissions_page');
}

function my_contact_plugin_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_contact_form_submissions';
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    ?>
    <div class="wrap">
        <h1>Contact Form Submissions</h1>
        <?php if (!empty($submissions)) : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission) : ?>
                        <tr>
                            <td><?php echo $submission->contact_name; ?></td>
                            <td><?php echo $submission->contact_email; ?></td>
                            <td><?php echo $submission->contact_message; ?></td>
                            <td><?php echo $submission->submission_date; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No submissions found.</p>
        <?php endif; ?>
    </div>
    <?php
}
