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
	// Define some constants we'll use later.
	define( 'EI_CONSENT_MANAGEMENT_DIR', dirname( __DIR__ ) );
	define( 'EI_CONSENT_MANAGEMENT_FILE', EI_CONSENT_MANAGEMENT_DIR . '/plugin.php' );
	defined( 'PANTHEON_EDGE_INTEGRATIONS_FILE' ) or define( 'PANTHEON_EDGE_INTEGRATIONS_FILE', WP_PLUGIN_DIR . '/pantheon-wordpress-edge-integrations/pantheon-wordpress-edge-integrations.php' );
	$plugin_data = get_file_data( EI_CONSENT_MANAGEMENT_FILE, array( 'Version' => 'Version' ) );
	$plugin_version = $plugin_data['Version'];
	define( 'EI_CONSENT_MANAGEMENT_VERSION', $plugin_version );
	$plugin = PANTHEON_EDGE_INTEGRATIONS_FILE;

	// Makre sure WP Consent API is loaded.
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\maybe_require_wp_consent_api', 9 );

	// Register the EI plugin with the Consent API.
	add_filter( "wp_consent_api_registered_$plugin", '__return_true' );
	add_filter( 'wp_get_consent_type', __NAMESPACE__ . '\\set_consent_type' );
	add_action( 'init', __NAMESPACE__ . '\\check_consent' );
	add_action( 'admin_init', __NAMESPACE__ . '\\suggest_privacy_policy_text' );
	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
		add_action( 'wp_footer', __NAMESPACE__ . '\\load_consent_banner' );
	}
}

/**
 * Require the WP Consent API if it's not already loaded.
 */
function maybe_require_wp_consent_api() {
	if ( ! class_exists( 'WP_CONSENT_API' ) ) {
		require_once dirname( __FILE__, 2 ) . '/vendor/rlankhorst/wp-consent-level-api/wp-consent-api.php';
	}
}

/**
 * Enqueue CSS and JS.
 */
function enqueue_assets() {
	$js = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? plugin_dir_url( __DIR__ ) . 'assets/js/main.js' : plugin_dir_url( __DIR__ ) . 'dist/js/main.js';
	$css = plugin_dir_url( __DIR__ ) . 'dist/css/styles.css';

	wp_enqueue_script( 'pantheon-ei-consent', $js, [ 'wp-consent-api' ], EI_CONSENT_MANAGEMENT_VERSION, true );
	wp_enqueue_style( 'pantheon-ei-consent', $css, [ 'dashicons' ], EI_CONSENT_MANAGEMENT_VERSION, 'screen' );
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
		add_filter( 'pantheon.ei.supported_vary_headers', __NAMESPACE__ . '\\do_not_send_vary_headers' );
		add_filter( 'pantheon.ei.post_types', __NAMESPACE__ . '\\do_not_allow_any_post_types' );
	}
}

/**
 * Callback function for the `pantheon.ei.supported_vary_headers` filter.
 * Denies all vary headers.
 *
 * @return array An array of rejected vary headers.
 */
function do_not_send_vary_headers() : array {
	return [
		'Audience-Set' => false,
		'Audience' => false,
		'Interest' => false,
	];
}

/**
 * Callback function for the `pantheon.ei.post_types` filter.
 * Sets the supported post types to a non-existant type.
 *
 * @return array An array of allowed post types.
 */
function do_not_allow_any_post_types() : array {
	return [ 'none' ];
}

/**
 * Defines the consent type.
 *
 * @return string The consent type.
 */
function set_consent_type() : string {
	return 'optin';
}

/**
 * Suggest the privacy policy text.
 */
function suggest_privacy_policy_text() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}

	$content = sprintf(
		'<h2>%1$s</h2>
		<p>
		<strong class="privacy-policy-tutorial">%2$s</strong>
		%3$s</p>',
		__( 'Pantheon WordPress Edge Integrations', 'pantheon-edge-integrations-consent-management' ),
		__( 'Suggested Text:', 'pantheon-edge-integrations-consent-management' ),
		__( 'This site uses cookies to track your interests and to improve your site experience. By accepting all cookies, you are consenting to the use of this information.', 'pantheon-edge-integrations-consent-management' )
	);

	wp_add_privacy_policy_content(
		__( 'Pantheon WordPress Edge Integrations', 'pantheon-edge-integrations-consent-management' ),
		wp_kses_post( wpautop( $content, false ) )
	);
}
