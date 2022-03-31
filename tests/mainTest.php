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

	public function testDoNotSendVaryHeaders() {
		$vary_headers = do_not_send_vary_headers();

		$this->assertTrue( is_array( $vary_headers ) );
		$this->assertFalse( $vary_headers['Audience'] );
		$this->assertFalse( $vary_headers['Audience-Set'] );
		$this->assertFalse( $vary_headers['Interest'] );
	}

	public function testDoNotAllowAnyPostTypes() {
		$post_types = do_not_allow_any_post_types();

		$this->assertTrue( is_array( $post_types ) );
		$this->assertContains( 'none', $post_types );
	}

	public function testSetConsentType() {
		$this->assertEquals( 'optin', set_consent_type() );
	}
}
