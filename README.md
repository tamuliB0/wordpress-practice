# WordPress Plugin Practice

### A collection of simple WordPress plugins built to learn how hooks, databases, and admin menus work.

This project is a hands-on way to learn WordPress backend development. It contains small, focused plugins that show how to add custom features, save data to a database, send emails, and create custom pages in the WordPress dashboard.

---
## Requirements

- [DDEV](https://ddev.com/) (v1.25.2)
- Docker

## Getting Started

This project uses `type: wordpress` in DDEV, which provides the `ddev wp` command for running [WP-CLI](https://wp-cli.org/) operations directly inside the container.

### 1. Start the environment

```bash
cd wordpress-practice
ddev start
```

### 2. Download and install WordPress

```bash
ddev wp core download --skip-content
ddev wp core install --url='$DDEV_PRIMARY_URL' --title='Demo site' --admin_user=admin --admin_password=admin --admin_email=admin@example.com
```

Your site will be available at **https://demo-site.ddev.site**

| Detail | Value |
|---|---|
| Site URL | https://demo-site.ddev.site |
| Admin URL | https://demo-site.ddev.site/wp-admin |
| Username | `admin` |
| Password | `admin` |

### 3. Add a plugin

Each plugin in this repository is a self-contained folder. To test any plugin:

1. Copy the plugin folder from this repo into your local `demo-site/wp-content/plugins/` directory.
2. Go to the WordPress admin → **Plugins** and activate it, or use WP-CLI:

```bash
ddev wp plugin activate <plugin-folder-name>
```

That's it — the plugin is now active and ready to test on your local site.

## Plugins

 - [contact-form](https://github.com/tamuliB0/wordpress-practice/tree/main/contact-form) - a form that collects and stores submissions, sends acknowledgment mail.
 - [copyright](https://github.com/tamuliB0/wordpress-practice/tree/main/copyright) - displays a custom message in the footer section
 - [current-date-shortcode](https://github.com/tamuliB0/wordpress-practice/tree/main/current-date-shortcode) - adds a shortcode that can be placed in any page/post which will display the current date-time
 - [dynamic-shortcode](https://github.com/tamuliB0/wordpress-practice/tree/main/dynamic-shortcode) - adds a shortcode which displays custom message based on user authentication
 - [hello-world](https://github.com/tamuliB0/wordpress-practice/tree/main/hello-world) - a simple "hello world" text at the top-left of admin page
 - [my-custom-menu](https://github.com/tamuliB0/wordpress-practice/tree/main/my-custom-menu) - this plugin creates a dedicated page in the WordPress admin dashboard with a custom menu item
 - [visitor-tracker](https://github.com/tamuliB0/wordpress-practice/tree/main/visitor-tracker) - it tracks a login and displays IP adrress, device and time stamp with a dedicated page in admin dashboard
 - [mail-test](https://github.com/tamuliB0/wordpress-practice/tree/main/mail-test) - helps track status of plugin with wp-mail