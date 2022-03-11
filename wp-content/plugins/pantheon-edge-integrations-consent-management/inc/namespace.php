<?php
/**
 * Main EI Consent Management namespace.
 *
 * @package Pantheon/EdgeIntegrations/ConsentManagement
 */

namespace Pantheon\EI\Consent;


/**
 * Bootstrap the plugin.
 */
function bootstrap() {
	// Register the EI plugin with the Consent API.
	$plugin = WP_PLUGIN_DIR . '/pantheon-wordpress-edge-integrations/pantheon-wordpress-edge-integrations.php';
	add_filter( "wp_consent_api_registered_$plugin", '__return_true' );
}

