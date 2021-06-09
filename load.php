<?php
/**
 * Loader for the pearlfibersSDK
 *
 * Logic for loading always the latest SDK from the installed themes/plugins.
 *
 * @package     pearlfibersSDK
 * @copyright   Copyright (c) 2017, Marius Cristea
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
// Current SDK version and path.
$pearlfibers_sdk_version = '3.2.20';
$pearlfibers_sdk_path    = dirname( __FILE__ );

global $pearlfibers_sdk_max_version;
global $pearlfibers_sdk_max_path;

// If this is the latest SDK and it comes from a theme, we should load licenser separately.
$pearlfibers_sdk_relative_licenser_path = '/src/Modules/Licenser.php';

global $pearlfibers_sdk_abs_licenser_path;
if ( ! is_file( $pearlfibers_sdk_path . $pearlfibers_sdk_relative_licenser_path ) && is_file( $pearlfibers_sdk_max_path . $pearlfibers_sdk_relative_licenser_path ) ) {
	$pearlfibers_sdk_abs_licenser_path = $pearlfibers_sdk_max_path . $pearlfibers_sdk_relative_licenser_path;
	add_filter( 'pearlfibers_sdk_required_files', 'pearlfibers_sdk_load_licenser_if_present' );
}
if ( version_compare( $pearlfibers_sdk_version, $pearlfibers_sdk_max_path ) == 0 &&
	apply_filters( 'pearlfibers_sdk_should_overwrite_path', false, $pearlfibers_sdk_path, $pearlfibers_sdk_max_path ) ) {
	$pearlfibers_sdk_max_path = $pearlfibers_sdk_path;
}

if ( version_compare( $pearlfibers_sdk_version, $pearlfibers_sdk_max_version ) > 0 ) {
	$pearlfibers_sdk_max_version = $pearlfibers_sdk_version;
	$pearlfibers_sdk_max_path    = $pearlfibers_sdk_path;
}

// load the latest sdk version from the active pearlfibers products.
if ( ! function_exists( 'pearlfibers_sdk_load_licenser_if_present' ) ) :
	/**
	 * Always load the licenser, if present.
	 *
	 * @param array $to_load Previously files to load.
	 */
	function pearlfibers_sdk_load_licenser_if_present( $to_load ) {
		global $pearlfibers_sdk_abs_licenser_path;
		$to_load[] = $pearlfibers_sdk_abs_licenser_path;

		return $to_load;
	}
endif;

// load the latest sdk version from the active pearlfibers products.
if ( ! function_exists( 'pearlfibers_sdk_load_latest' ) ) :
	/**
	 * Always load the latest sdk version.
	 */
	function pearlfibers_sdk_load_latest() {
		/**
		 * Don't load the library if we are on < 5.4.
		 */
		if ( version_compare( PHP_VERSION, '5.4.32', '<' ) ) {
			return;
		}
		global $pearlfibers_sdk_max_path;
		require_once $pearlfibers_sdk_max_path . '/start.php';
	}
endif;
add_action( 'init', 'pearlfibers_sdk_load_latest' );
