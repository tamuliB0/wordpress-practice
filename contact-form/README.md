# Contact form

In this plugin, I learned how to create a complete contact form system with database storage and admin management.

To make this work, I had to learn about :
 - [register_activation_hook](https://developer.wordpress.org/reference/functions/register_activation_hook/),
 - [add_shortcode](https://developer.wordpress.org/reference/functions/add_shortcode/) , 
 - [add_menu_page](https://developer.wordpress.org/reference/functions/add_menu_page/)  


# How to use
In any post/page, use the shortcode `my_contact_form` to display the contact form.

# What would be displayed to users
Users see a simple form with name, email, and message fields. After submission, they see a customizable thank you message and receive an email confirmation.

![output.](contact-form/output.png)