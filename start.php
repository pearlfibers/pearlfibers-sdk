<?php
/**
 * File responsible for sdk files loading.
 *
 * @package     pearlfibersSDK
 * @copyright   Copyright (c) 2017, Marius Cristea
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.0
 */

namespace pearlfibersSDK;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$products               = apply_filters( 'pearlfibers_sdk_products', array() );
$pearlfibers_library_path = dirname( __FILE__ );
$files_to_load          = [
	$pearlfibers_library_path . '/src/Loader.php',
	$pearlfibers_library_path . '/src/Product.php',

	$pearlfibers_library_path . '/src/Common/Abstract_module.php',
	$pearlfibers_library_path . '/src/Common/Module_factory.php',

	$pearlfibers_library_path . '/src/Modules/Dashboard_widget.php',
	$pearlfibers_library_path . '/src/Modules/Rollback.php',
	$pearlfibers_library_path . '/src/Modules/Uninstall_feedback.php',
	$pearlfibers_library_path . '/src/Modules/Licenser.php',
	$pearlfibers_library_path . '/src/Modules/Endpoint.php',
	$pearlfibers_library_path . '/src/Modules/Notification.php',
	$pearlfibers_library_path . '/src/Modules/Logger.php',
	$pearlfibers_library_path . '/src/Modules/Translate.php',
	$pearlfibers_library_path . '/src/Modules/Review.php',
	$pearlfibers_library_path . '/src/Modules/Recommendation.php',
];

$files_to_load = array_merge( $files_to_load, apply_filters( 'pearlfibers_sdk_required_files', [] ) );

foreach ( $files_to_load as $file ) {
	if ( is_file( $file ) ) {
		require_once $file;
	}
}

Loader::init();

foreach ( $products as $product ) {
	Loader::add_product( $product );
}
