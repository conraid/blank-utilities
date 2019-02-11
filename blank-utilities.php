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
Version: 2.1
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
define( 'VERSION', '2.1' );



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

if ( ! function_exists( 'blank_remove_version' ) ) {
	/**
	 * Remove versione string from WordPress tag.
	 *
	 * @since Blank_Utilities 1.0
	 */
	function blank_remove_version() {
		return '';
	}
}
add_filter( 'the_generator', 'blank_remove_version' );


if ( ! function_exists( 'blank_remove_version_css_js' ) ) {
	/**
	 * Remove version string from any enqueued scripts.
	 *
	 * @since Blank_Utilities 0.1
	 *
	 * @param string $src WordPress scripts.
	 *
	 * @return string src without version.
	 */
	function blank_remove_version_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}
}
add_filter( 'style_loader_src', 'blank_remove_version_css_js', 9999 );
add_filter( 'script_loader_src', 'blank_remove_version_css_js', 9999 );


if ( ! function_exists( 'blank_login_logo' ) ) {
	/**
	 * Show blank logo in login page
	 *
	 * @since Blank_Utilities 1.0
	 */
	function blank_login_logo() {
		if ( file_exists( get_stylesheet_directory() . '/images/logo_login.png' ) ) {
			$blank_images = get_stylesheet_directory_uri() . '/images/logo_login.png';
		} else {
			$blank_images = plugins_url( 'images/logo_blank.png', __FILE__ );
		}
		list( $width, $height ) = getimagesize( $blank_images );
		wp_enqueue_style( 'blank_login_css', plugins_url( '/css/login_blank.css', __FILE__ ), '', VERSION );
		$blank_login_css = ".login h1 a {
		background-image:url(\"$blank_images\");
		width:{$width}px;
		height:{$height}px;
		}";
		wp_add_inline_style( 'blank_login_css', $blank_login_css );
	}
}
add_action( 'login_enqueue_scripts', 'blank_login_logo' );

if ( ! function_exists( 'blank_login_logo_url' ) ) {
	/**
	 * Show home page url
	 *
	 * @since Blank_Utilities 1.0
	 *
	 * @return home page url
	 */
	function blank_login_logo_url() {
		return home_url();
	}
}
add_filter( 'login_headerurl', 'blank_login_logo_url' );


if ( ! function_exists( 'blank_login_logo_url_title' ) ) {
	/**
	 * Show title blank
	 *
	 * @since Blank_Utilities 1.0
	 *
	 * @return title home page url
	 */
	function blank_login_logo_url_title() {
		return '';
	}
}
add_filter( 'login_headertitle', 'blank_login_logo_url_title' );



if ( ! function_exists( 'caldera_phone_italy' ) ) {
	/**
	  * Set Italy for Caldera Forms phone fields
	  *
	  * @since Blank_Utilities 2.0
	  *
	  * @return options
	  */
	function caldera_phone_italy() {
		// Use ISO_3166-1_alpha-2 formatted country code.
		$options['preferredCountries'] = array( 'IT', 'CH' );
		$options['initialCountry']     = 'IT';
		//$options['onlyCountries'] = array( 'IT', 'CH' );
		return $options;
	}
}
add_filter( 'caldera_forms_phone_js_options', 'caldera_phone_italy' );

