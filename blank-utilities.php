<?php
/**
 * Some utilities for WordPress for my personal and particolar use
 *
 * PHP version 7
 *
 * @category  Wordpress_Plugin
 * @package   Blank_Utilities
 * @author    Corrado Franco <conraid@linux.it>
 * @copyright 2016/2019 Corrado Franco
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-3.0.html GPL-3
 * @link      https://github.com/conraid/blank-utilities
 */

/*
Plugin Name: Blank Utilities
Plugin URI: https://github.com/conraid/blank-utilities
Description: Some utilities for WordPress for my personal and particolar use
Version: 2.6
Author: Corrado Franco <conraid@linux.it>
Author URI: http://conraid.net
License: GPL-3
Text Domain: utility
*/

/**
 * Copyright 2016/2019 Corrado Franco <conraid@linux.it>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Set version number
 *
 * @since Blank_Utilitities 2.0
 */
define( 'BLANK_UTILITIES_VERSION', '2.3' );

/**
 * Show link manager
 *
 * @since Blank_Utilities 1.0
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/**
 * Remove version number.
 *
 * @since Blank_Utilities 1.0
 */
remove_action( 'wp_head', 'wp_generator' );

if ( ! function_exists( 'blankuti_remove_wpversion' ) ) {
	/**
	 * Remove versione string from WordPress tag.
	 *
	 * @since Blank_Utilities 1.0
	 */
	function blankuti_remove_wpversion() {
		return '';
	}
}
add_filter( 'the_generator', 'blankuti_remove_wpversion' );

if ( ! function_exists( 'blankuti_remove_version_css_js' ) ) {
	/**
	 * Remove version string from any enqueued scripts.
	 *
	 * @since Blank_Utilities 0.1
	 *
	 * @param string $src WordPress scripts.
	 *
	 * @return string src without version.
	 */
	function blankuti_remove_version_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
}
add_filter( 'style_loader_src', 'blankuti_remove_version_css_js', 9999 );
add_filter( 'script_loader_src', 'blankuti_remove_version_css_js', 9999 );

if ( ! function_exists( 'blankuti_login_logo' ) ) {
	/**
	 * Show blank logo in login page
	 *
	 * @since Blank_Utilities 1.0
	 */
	function blankuti_login_logo() {
		if ( file_exists( get_stylesheet_directory() . '/images/logo_login.png' ) ) {
			$blankuti_images = get_stylesheet_directory_uri() . '/images/logo_login.png';
		} else {
			$blankuti_images = plugins_url( 'images/logo_blank.png', __FILE__ );
		}
		list( $width, $height ) = getimagesize( $blankuti_images );
		wp_enqueue_style( 'blankuti_login_css', plugins_url( '/css/login_blank.css', __FILE__ ), '', BLANK_UTILITIES_VERSION );
		$blankuti_login_css = "#login h1 a, .login h1 a {
		background-image:url(\"$blankuti_images\");
		background-repeat: no-repeat;
		width:{$width}px;
		height:{$height}px;
		}";
		wp_add_inline_style( 'blankuti_login_css', $blankuti_login_css );
	}
}
add_action( 'login_enqueue_scripts', 'blankuti_login_logo' );

if ( ! function_exists( 'blankuti_login_logo_url' ) ) {
	/**
	 * Show home page url
	 *
	 * @since Blank_Utilities 1.0
	 *
	 * @return string Home Page URL
	 */
	function blankuti_login_logo_url() {
		return home_url();
	}
}
add_filter( 'login_headerurl', 'blankuti_login_logo_url' );

if ( ! function_exists( 'blankuti_login_logo_url_title' ) ) {
	/**
	 * Show title blank
	 *
	 * @since Blank_Utilities 1.0
	 *
	 * @return null title home page url
	 */
	function blankuti_login_logo_url_title() {
		return '';
	}
}
add_filter( 'login_headertitle', 'blankuti_login_logo_url_title' );

if ( ! function_exists( 'blankuti_no_login_errors' ) ) {
	/**
	 * Not show errors
	 *
	 * @since Blank_Utilities 2.3
	 *
	 * @return string Clean message.
	 */
	function blankuti_no_login_errors() {
		return __( 'An error occurred. Please try again.' );
	}
}
add_filter( 'login_errors', 'blankuti_no_login_errors' );

if ( ! function_exists( 'blankuti_svg_mime_types' ) ) {
	/**
	 * Allowed SVG mime types and file extensions
	 *
	 * @since Blank_Utilities 2.5
	 *
	 * @param array $mimes mime types.
	 * @return array $mimes Mime types with svg.
	 */
	function blankuti_svg_mime_types( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'blankuti_svg_mime_types' );
}

if ( ! function_exists( 'blankuti_display_search_form' ) ) {
	/**
	 * Display standard search form
	 *
	 * @since Blank_Utilities 2.6
	 */
	function blankuti_display_search_form() {
		return get_search_form( false );
	}
}
add_shortcode( 'display_search_form', 'blankuti_display_search_form' );

/**
 * Add shortcode to the widgets text
 *
 * @since Blank_Utilities 2.6
 */
add_filter( 'widget_text', 'do_shortcode' );
