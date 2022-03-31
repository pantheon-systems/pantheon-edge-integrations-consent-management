<?php
namespace Pantheon\EI\Consent;

use PHPUnit\Framework\TestCase;

class testsMain extends TestCase {
	protected function setUp() : void {
		parent::setUp();
		// Load the consent api plugin.
		$consent_api_path = dirname( __DIR__ ) . '/vendor/rlankhorst/wp-consent-level-api/';
		require_once "$consent_api_path/wp-consent-api.php";
		require_once "$consent_api_path/api.php";
	}

	public function testWPConsentAPIisLoaded() {
		$this->assertTrue( function_exists( 'wp_consent_api_activation_check' ) );
		$this->assertTrue( function_exists( 'wp_has_consent' ) );
	}
	}
}
