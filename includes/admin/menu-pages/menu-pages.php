<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Page menus array
function resize_images_in_posts__menu_page( $settings_options = array() ) {

	$admin_panel_help_theme_options = array();
	
	$admin_panel_help_theme_options['id_3'] = array(
		'title'      => __( 'About Admin Panel' , 'resize_images_in_posts' ),
		'content'    => '<p>' . __( 'The admin panel will help to change some settings of the plugin.', 'resize_images_in_posts' ) . '</p>'
	);

	$admin_panel_help_theme_options['id_4'] = array(
		'title'      => __( 'About Resize Images In Posts' , 'resize_images_in_posts' ),
		'content'    => '<p>' . __( 'If you want to resize images in your posts automatically so the page will load faster and use less bandwidth then this plugin can help you.' , 'resize_images_in_posts' ) . '</p>' .
		'<p>' . '<strong>' . __( 'Note: ', 'resize_images_in_posts' ) . '</strong>' . __( 'The filter - "wp_make_content_images_responsive" will be deactivated because with this plugin we will not need anymore.' , 'resize_images_in_posts' ) . '</p>' . 
		'<p>' . __( 'What settings you can change:' , 'resize_images_in_posts' ) . '</p>' .
		
		'<ul>' .
			'<li>' . __( 'Check or uncheck to make the plugin resize images in the posts or not.', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Method of resizing images: Auto mode or Custom size mode.', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Images maximal width (in px).', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Disable or Enable resizing gif images.', 'resize_images_in_posts' ) . '</li>' .
		'</ul>'
	);
	
	$admin_panel_help_theme_options['id_'] = array(
		'title'      => __( 'About Resize Images In Text Widget' , 'resize_images_in_posts' ),
		'content'    => '<p>' . __( 'With version 4.3 now you can resize images in Text Widgets.' , 'resize_images_in_posts' ) . '</p>' .
		'<p>' . __( 'What settings you can change:' , 'resize_images_in_posts' ) . '</p>' .
		
		'<ul>' .
			'<li>' . __( 'Check or uncheck to make the plugin to start or to stop resizing images in Text Widgets.', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Method of resizing images: Auto mode or Custom size mode.', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Images maximal width (in px).', 'resize_images_in_posts' ) . '</li>' .
			'<li>' . __( 'Disable or Enable resizing gif images.', 'resize_images_in_posts' ) . '</li>' .
		'</ul>'
	);
	
	// Theme options
	$settings_options['theme_options'] = array(
		'use_admin_panel'       => true,
		'page_title'            => __( 'Resize Images In Posts and Text Widget Settings', 'resize_images_in_posts' ),
		'menu_title'            => __( 'Resize Images In Posts', 'resize_images_in_posts' ),
		'capability'            => 'edit_theme_options',
		'menu_slug'             => 'resize_images_in_posts',
		'function'              => 'resize_images_in_posts__admin_panel_settings',
		'help'                  => apply_filters( 'resize_images_in_posts__filter_admin_menu_help_text', $admin_panel_help_theme_options ),
		'scripts'               => array(
			'resize-images-in-posts-admin-panel',
			'jquery-ui-accordion'
		),
		'styles'                => array(
			'resize-images-in-posts-admin-panel'
		)
	);

	return $settings_options;
}