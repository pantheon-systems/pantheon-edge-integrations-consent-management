<?php
/**
 * Bootstrap tests.
 */

// Call the autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Bootstrap WordPress.
 */
defined( 'ABSPATH' ) or define( 'ABSPATH', __DIR__ . '/../../vendor/wordpress/wordpress/src/' );
defined( 'WPINC' ) or define( 'WPINC', 'wp-includes' );
defined( 'WP_PLUGIN_DIR' ) or define( 'WP_PLUGIN_DIR', '/../../../' );
defined( 'WPMU_PLUGIN_DIR' ) or define( 'WPMU_PLUGIN_DIR', '/../../../' );
require_once ABSPATH . WPINC . '/default-constants.php';
require_once ABSPATH . WPINC . '/functions.php';
require_once ABSPATH . WPINC . '/load.php';
require_once ABSPATH . WPINC . '/plugin.php';
wp_initial_constants();
$wp_plugin_paths = [];

// Load our plugin.
require_once __DIR__ . '/../../plugin.php';
