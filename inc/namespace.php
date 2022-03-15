<?php
/**
 * Main EI Consent Management namespace.
 *
 * @package Pantheon/EdgeIntegrations/ConsentManagement
 */

namespace Pantheon\EI\Consent;

use Pantheon\EI\WP\Interest;

/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	// Register the EI plugin with the Consent API.
	$plugin = WP_PLUGIN_DIR . '/pantheon-wordpress-edge-integrations/pantheon-wordpress-edge-integrations.php';
	add_filter( "wp_consent_api_registered_$plugin", '__return_true' );
	add_filter( 'wp_get_consent_type', __NAMESPACE__ . '\\set_consent_type' );
	add_action( 'init', __NAMESPACE__ . '\\check_consent' );
	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
		add_action( 'wp_footer', __NAMESPACE__ . '\\load_consent_banner' );
	}
}

/**
 * Enqueue CSS and JS.
 */
function enqueue_assets() {
	$js = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? plugin_dir_url( __DIR__ ) . 'assets/js/main.js' : plugin_dir_url( __DIR__ ) . 'dist/js/main.js';
	$css = plugin_dir_url( __DIR__ ) . 'dist/css/styles.css';

	wp_enqueue_script( 'pantheon-ei-consent', $js, [ 'wp-consent-api' ], '0.1.0', true );
	wp_enqueue_style( 'pantheon-ei-consent', $css, [], '0.1.0', 'screen' );
}

/**
 * Load the consent banner.
 */
function load_consent_banner() {
	load_template( plugin_dir_path( __DIR__ ) . 'templates/cookie-banner.php' );
}

/**
 * Register the cookies with the Consent API.
 */
function register_cookies() {
	// Bail if the wp_add_cookie_info function doesn't exist.
	if ( ! function_exists( 'wp_add_cookie_info' ) ) {
		return;
	}
	// Register the Interest cookie.
	wp_add_cookie_info(
		'interest', // The name of the cookie.
		__( 'Pantheon WordPress Edge Integrations', 'pantheon-edge-integrations-consent-management' ), // The plugin or service that sets the cookie.
		'marketing', // The type of cookie.
		Interest\get_cookie_expiration(), // The expiration time.
		'User interest data.' // What the cookie is meant to do.
	);

	wp_add_cookie_info(
		'pantheon_ei.interest', // The name of the cookie.
		__( 'Pantheon WordPress Edge Integrations', 'pantheon-edge-integrations-consent-management' ), // The plugin or service that sets the cookie.
		'marketing', // The type of cookie.
		Interest\get_cookie_expiration(), // The expiration time.
		'User interest data.', // What the cookie is meant to do.
		'Interest tracking', // The type of personal data that is collected.
		false, // Not a member cookie.
		false, // Not an administrator-only cookie.
		'LOCALSTORAGE' // The cookie type.
	);
}

/**
 * Check for cookie consent. If consent hasn't been given, don't vary on interest or geo.
 */
function check_consent() {
	if ( ! function_exists( 'wp_has_consent' ) ) {
		return;
	}

	if ( ! wp_has_consent( 'marketing' ) ) {
		// If consent hasn't been granted, don't vary the cache.
		add_filter( 'pantheon.ei.supported_vary_headers', function() {
			return [
				'Audience-Set' => false,
				'Audience' => false,
				'Interest' => false,
			];
		 } );

		// Dequeue the interest script.
		wp_dequeue_script( 'pantheon-ei-interest' );
	}
}

/**
 * Defines the consent type.
 *
 * @return string The consent type.
 */
function set_consent_type() : string {
	return 'optin';
}