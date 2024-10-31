<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


$default_settings_functions = resize_images_in_posts__default_settings_functions();

if ( ! empty( $default_settings_functions ) ) {
	foreach ( (array) $default_settings_functions as $option_id => $option_function ) {
		add_filter( 'resize_images_in_posts__default_option_' . $option_id, $option_function );
	}
}


$resize_images_in_posts = resize_images_in_posts();
$plugin_file = $resize_images_in_posts->file;

// Plugin Activation
register_activation_hook( $plugin_file,                               'resize_images_in_posts__activation_action'                          );

// Plugin Deactivation
register_deactivation_hook( $plugin_file,                             'resize_images_in_posts__deactivation_action'                        );


$resize_images_in_posts = resize_images_in_posts__get_option( 'resize_images_in_posts_settings_resize_images_in_posts' );

// Check if option is enabled
if ( (bool) $resize_images_in_posts ) {

	// Remove action to resize images for responsive sites because we have our function and do not need it
	remove_filter( 'the_content',                                         'wp_make_content_images_responsive'                              );

	// Resize all the images in all posts
	add_filter( 'the_content',                                            'resize_images_in_posts__in_posts', 100                          );
}


$resize_images_in_text_widgets = resize_images_in_posts__get_option( 'resize_images_in_posts_settings_resize_images_in_text_widgets' );

// Check if option is enabled
if ( (bool) $resize_images_in_text_widgets ) {
	// Add filter to text widget
	add_filter( 'widget_text',                                            'resize_images_in_posts__in_text_widgets', 100                   );
}

// Change admin panel maximum image width value after theme change
add_action( 'after_switch_theme',                                         'resize_images_in_posts__after_switch_theme'                     );