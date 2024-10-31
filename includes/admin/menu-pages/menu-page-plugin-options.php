<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


function resize_images_in_posts__admin_panel_settings( $settings_options = array() ) {
	$resize_images_in_posts           = resize_images_in_posts();
	$settings_id                      = $resize_images_in_posts->settings_id;

	$how_to_resize_in_posts           = resize_images_in_posts__get_option( $settings_id . 'how_to_resize_in_posts', 'auto_size' );

	if ( (string) $how_to_resize_in_posts == (string) 'auto_size' ) {
		$row_style_in_posts = 'display: none;';
	} else {
		$row_style_in_posts = 'display: block;';
	}
	
	$how_to_resize_in_text_widgets    = resize_images_in_posts__get_option( $settings_id . 'how_to_resize_in_text_widgets', 'auto_size' );
	
	if ( (string) $how_to_resize_in_text_widgets == (string) 'auto_size' ) {
		$row_style_in_text_widgets = 'display: none;';
	} else {
		$row_style_in_text_widgets = 'display: block;';
	}
	
	$settings_options['general'] = array(
		'name'              => __( 'General', 'resize_images_in_posts' ),
		'priority'          => 10,
		'submenus'          => array(
		
			'resize_in_posts' => array(
				'name'              => __( 'Resize In Posts', 'resize_images_in_posts' ),
				'priority'          => 10,
				'rows'              => array(

					'resize_images_in_posts' => array(
						'description'   => __( 'Uncheck this if you want the plugin not to work.', 'resize_images_in_posts' ),
						'priority'      => 20,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Resize Images in Posts?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'checkbox',
								'id'              => $settings_id . 'resize_images_in_posts'
							)
						)
					),
				
					'how_to_resize' => array(
						'description'   => __( 'You can select Auto Size to resize the images automatically or to select Custom Size to insert your own size. If you select Auto Size then the plugin will use global $content_width value but if you select the Custom Size you will need to provide custom size in pixels.', 'resize_images_in_posts' ),
						'priority'      => 25,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'How to resize images?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'select',
								'id'              => $settings_id . 'how_to_resize_in_posts',
								'onchange'        => "jQuery(this).closest( '.resize-images-in-posts-submenu-content' ).find( '.hide-item' ).hide().filter( '.show-item-' + jQuery(this).val() ).show();",
								'options'         => array(
									array(
										'tag'                => 'option',
										'value'              => 'auto_size',
										'text'               => __( 'Auto Size', 'wpimpress' )
									),
									array(
										'tag'                => 'option',
										'value'              => 'custom_size',
										'text'               => __( 'Custom Size', 'wpimpress' )
									),
								)
							)
						)
					),

					'custom_size' => array(
						'description'   => __( 'You can change the desired image width to a specific one (in pixels).', 'resize_images_in_posts' ),
						'priority'      => 30,
						'style'         => $row_style_in_posts,
						'class'         => 'hide-item show-item-custom_size',
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Image Maximum Width', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'number',
								'id'              => $settings_id . 'custom_size_in_posts'
							)
						)
					),

					'disable_resizing_gifs' => array(
						'description'   => __( 'Check this if you want the plugin to resize gif images too. Resizing images will make them static.', 'resize_images_in_posts' ),
						'priority'      => 50,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Resize GIF Images (image animations)?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'checkbox',
								'id'              => $settings_id . 'resize_gifs_in_posts'
							)
						)
					),
				)
			),
			
			'resize_in_text_widgets' => array(
				'name'              => __( 'Resize In Text Widgets', 'resize_images_in_posts' ),
				'priority'          => 20,
				'rows'              => array(

					'resize_images_in_posts' => array(
						'description'   => __( 'Check this to resize images in Text Widgets.', 'resize_images_in_posts' ),
						'priority'      => 20,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Resize Images in Text Widgets?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'checkbox',
								'id'              => $settings_id . 'resize_images_in_text_widgets'
							)
						)
					),
				
					'how_to_resize' => array(
						'description'   => __( 'You can select Auto Size to resize the images automatically or to select Custom Size to insert your own size. If you select Auto Size then the plugin will use global $content_width value but if you select the Custom Size you will need to provide custom size in pixels.', 'resize_images_in_posts' ),
						'priority'      => 25,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'How to resize images?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'select',
								'id'              => $settings_id . 'how_to_resize_in_text_widgets',
								'onchange'        => "jQuery(this).closest( '.resize-images-in-posts-submenu-content' ).find( '.hide-item' ).hide().filter( '.show-item-' + jQuery(this).val() ).show();",
								'options'         => array(
									array(
										'tag'                => 'option',
										'value'              => 'auto_size',
										'text'               => __( 'Auto Size', 'wpimpress' )
									),
									array(
										'tag'                => 'option',
										'value'              => 'custom_size',
										'text'               => __( 'Custom Size', 'wpimpress' )
									),
								)
							)
						)
					),

					'custom_size' => array(
						'description'   => __( 'You can change the desired image width to a specific one (in pixels).', 'resize_images_in_posts' ),
						'priority'      => 30,
						'style'         => $row_style_in_text_widgets,
						'class'         => 'hide-item show-item-custom_size',
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Image Maximum Width', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'number',
								'id'              => $settings_id . 'custom_size_in_text_widgets'
							)
						)
					),

					'disable_resizing_gifs' => array(
						'description'   => __( 'Check this if you want the plugin to resize gif images too. Resizing images will make them static.', 'resize_images_in_posts' ),
						'priority'      => 50,
						'tags'          => array(
						
							array(
								'tag'             => 'h3',
								'text'            => __( 'Resize GIF Images (image animations)?', 'resize_images_in_posts' )
							),
							array(
								'tag'             => 'input',
								'type'            => 'checkbox',
								'id'              => $settings_id . 'resize_gifs_in_text_widgets'
							)
						)
					),
				)
			),
			
			'info' => array(
				'name'               => __( 'Info', 'resize_images_in_posts' ),
				'priority'           => 90,
				'rows'               => array(
				
					'view_information' => array(
						'description'          => __( 'View information about your site.', 'resize_images_in_posts' ),
						'priority'             => 10,
						'tags'                 => array(
						
							array(
								'tag'                  => 'h3',
								'text'                 => __( 'Site information', 'resize_images_in_posts' )
							),
							array(
								'tag'                  => 'textarea',
								'class'                => 'code-text',
								'readonly'             => 'readonly',
								'id'                   => $settings_id . 'site_info',
								'use_default_value'    => true
							)
						)
					)
				)
			)
		)
	);

	return $settings_options;
}