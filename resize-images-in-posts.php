<?php
/*
 Plugin Name: Resize Images In Posts
 Plugin URI: http://wordpress.org/plugins/resize-images-in-posts
 Description: This plugin will resize images in your posts. (Go to: Dashboard -> Plugins -> Resize Images in Posts)
 Version: 4.3
 Author: Alexandru Vornicescu
 Author URI: http://alexvorn.com
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Function on plugin 
function resize_images_in_posts__activation_action() {
	// Nothing, just because
}

// Function on plugin deactivation
function resize_images_in_posts__deactivation_action() {
	// Nothing, just because
}

final class resize_images_in_posts {

	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) {
			$instance = new resize_images_in_posts;
			$instance->setup_globals();
			$instance->includes();
		}

		// Always return the instance
		return $instance;
	}
	
	private function setup_globals() {

		/** Versions **********************************************************/
		
		$this->version         = '4.3';

		// Setup some base path and URL information
		$this->file            = __FILE__;
		$this->basename        = plugin_basename( $this->file );
		$this->plugin_dir      = plugin_dir_path( $this->file );
		$this->plugin_url      = plugin_dir_url ( $this->file );

		// Includes
		$this->includes_dir    = trailingslashit( $this->plugin_dir . 'includes'  );
		$this->includes_url    = trailingslashit( $this->plugin_url . 'includes'  );
		
		/** Misc **************************************************************/
		$this->domain          = 'resize_images_in_posts';
		$this->settings_id     = 'resize_images_in_posts_settings_';    
	}
	
	private function includes() {
		
		require( $this->plugin_dir . 'default-settings-values.php'                           );
		require( $this->plugin_dir . 'actions.php'                                           );
		
		require( $this->includes_dir . 'functions.php'                                       );
		require( $this->includes_dir . 'image-resize.php'                                    );
		
		/** Admin *************************************************************/
		if ( is_admin() ) {
			require( $this->includes_dir . 'admin/menu-pages/menu-pages.php'                               );
			require( $this->includes_dir . 'admin/menu-pages/menu-page-plugin-options.php'                 );
			require( $this->includes_dir . 'admin/menu-pages/actions.php'                                  );

			require( $this->includes_dir . 'admin/functions.php'                                           );
			require( $this->includes_dir . 'admin/actions.php'                                             );
			require( $this->includes_dir . 'admin/admin-panel.php'                                         );
		}
	}
}


function resize_images_in_posts() {
	return resize_images_in_posts::instance();
}

// Function that will activate our plugin
resize_images_in_posts();


function resize_images_in_posts__in_posts( $content = '' ) {
	global $content_width;
	
	$resize_images_in_posts = resize_images_in_posts();
	$settings_id = $resize_images_in_posts->settings_id;

	// Get "how to resize" option
	$how_to_resize = resize_images_in_posts__get_option( $settings_id . 'how_to_resize_in_posts' );
	
	// If "how to resize" value is auto_resize then we use default $content_width value, else we will have a custom size value
	if ( (string) $how_to_resize == (string) 'auto_size' ) {
		$custom_size = (int) $content_width;
	} else {
		$custom_size = resize_images_in_posts__get_option( $settings_id . 'custom_size_in_posts' );
	}
	
	// Get value of resize_gifs option
	$resize_gifs = resize_images_in_posts__get_option( $settings_id . 'resize_gifs_in_posts' );

	$instance = array();

	if ( preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {

		foreach( $matches[0] as $image ) {

			// If we have src property and width property
			if ( preg_match( '/src="([^"]+)"/', $image, $image_url ) ) {

				$instance['thumbnail_url'] = $image_url[1];
				$instance['thumbnail_width'] = (int) $custom_size;
				$instance['thumbnail_resize_gif'] = (bool) $resize_gifs;

				$new_image_array = resize_images_in_posts__dynamically_image_resize( $instance );

				if ( ! empty( $new_image_array['url'] ) ) {
					$new_image = preg_replace( '/src="([^"]+)"/', 'src="' . $new_image_array['url'] . '"', $image );
					$new_image = preg_replace( '/width="([^"]+)"/', 'width="' . $new_image_array['width'] . '"', $new_image );
					$new_image = preg_replace( '/height="([^"]+)"/', 'height="' . $new_image_array['height'] . '"', $new_image );
					
					$content = str_replace( $image, $new_image, $content );
				}
			}
		}
	}

	return $content;
}


function resize_images_in_posts__in_text_widgets( $content = '' ) {
	global $content_width;
	
	$resize_images_in_posts = resize_images_in_posts();
	$settings_id = $resize_images_in_posts->settings_id;

	// Get "how to resize" option
	$how_to_resize = resize_images_in_posts__get_option( $settings_id . 'how_to_resize_in_text_widgets' );
	
	// If "how to resize" value is auto_resize then we use default $content_width value, else we will have a custom size value
	if ( (string) $how_to_resize == (string) 'auto_size' ) {
		$custom_size = (int) $content_width;
	} else {
		$custom_size = resize_images_in_posts__get_option( $settings_id . 'custom_size_in_text_widgets' );
	}
	
	// Get value of resize_gifs option
	$resize_gifs = resize_images_in_posts__get_option( $settings_id . 'resize_gifs_in_text_widgets' );

	$instance = array();

	if ( preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {

		foreach( $matches[0] as $image ) {

			// If we have src property and width property
			if ( preg_match( '/src="([^"]+)"/', $image, $image_url ) ) {

				$instance['thumbnail_url'] = $image_url[1];
				$instance['thumbnail_width'] = (int) $custom_size;
				$instance['thumbnail_resize_gif'] = (bool) $resize_gifs;

				$new_image_array = resize_images_in_posts__dynamically_image_resize( $instance );

				if ( ! empty( $new_image_array['url'] ) ) {
					$new_image = preg_replace( '/src="([^"]+)"/', 'src="' . $new_image_array['url'] . '"', $image );
					$new_image = preg_replace( '/width="([^"]+)"/', 'width="' . $new_image_array['width'] . '"', $new_image );
					$new_image = preg_replace( '/height="([^"]+)"/', 'height="' . $new_image_array['height'] . '"', $new_image );
					
					$content = str_replace( $image, $new_image, $content );
				}
			}
		}
	}

	return $content;
}

// Change admin panel maximum image width value after theme change
function resize_images_in_posts__after_switch_theme() {
	global $content_width;

	$resize_images_in_posts                 = resize_images_in_posts();
	$settings_id                            = $resize_images_in_posts->settings_id;

	if ( isset( $content_width ) ) {
		update_option( $settings_id . 'custom_size_in_posts', (int) $content_width );
		update_option( $settings_id . 'custom_size_in_text_widgets', (int) $content_width );
	}
}

// Our get_option function
function resize_images_in_posts__get_option( $option, $default = false, $use_default = false ) {
	
	if ( $default === false ) {
		$default_settings_values = resize_images_in_posts__default_settings_values();
		
		if ( isset( $default_settings_values[$option] ) ) {
			$default = $default_settings_values[$option];
		} else if ( $use_default === true ) {
			$default = get_option( $option, $default );
		}
	}

	$default = apply_filters( 'resize_images_in_posts__default_option_' . $option, $default );
	
	if ( $use_default === true ) {
		$get_option = $default;
	} else {
		$get_option = get_option( $option, $default );
	}
	
	return $get_option;
}