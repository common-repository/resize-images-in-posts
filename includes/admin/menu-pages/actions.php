<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Theme options
add_filter( 'resize_images_in_posts__add_menu_page_settings', 'resize_images_in_posts__menu_page' );