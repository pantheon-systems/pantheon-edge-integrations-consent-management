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
}

function register_cookies() {
	if ( function_exists( 'wp_add_cookie_info' ) ) {
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
}
