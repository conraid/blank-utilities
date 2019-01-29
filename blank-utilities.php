<?php
/**
 * Some utilities for WordPress
 *
 * PHP version 5
 *
 * @category  Wordpress_Plugin
 * @package   Blank_Utilities
 * @author    Corrado Franco <conraid@linux.it>
 * @copyright 2016/2019 Corrado Franco
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GPL-2
 * @link      https://github.com/conraid/blank-utilities
 */

/*
Plugin Name: Blank_Utilities
Plugin URI: https://github.com/conraid/blank-utilities
Description: Some utilities for WordPress
Version: 1.0
Author: Corrado Franco <conraid@linux.it>
Author URI: http://conraid.net
License: GPL-2
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

/**
 * Blank Utilities
 *
 * @since Blank_Utilitities 1.0
 */

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
add_filter( 'style_loader_src', 'blank_remove_version_css_js', 9999 );
add_filter( 'script_loader_src', 'blank_remove_version_css_js', 9999 );


/**
 * Check if logo_form image exist
 *
 * @since Blank_Utilities 1.0
 */
if ( file_exists( get_stylesheet_directory() .'/images/logo_form.png' ) ) {
	/**
	 * Show blank logo in login page
	 *
	 * @since Blank_Utilities 1.0
	 */
	function blank_login_logo() { ?>
	<style type="text/css">
		#login h1 a {
			background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/images/logo_form.png");
			padding-bottom: 30px;
		}
	</style>
<?php }
	add_action( 'login_enqueue_scripts', 'blank_login_logo' );
}

/**
 * Show
 *
 * @since Blank_Utilities 1.0
 *
 * @return home page url
 */
function blank_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'blank_login_logo_url' );

/**
 * Show
 *
 * @since Blank_Utilities 1.0
 *
 * @return title home page url
 */
function blank_login_logo_url_title() {
	return 'pippo';
}
add_filter( 'login_headertitle', 'blank_login_logo_url_title' );

