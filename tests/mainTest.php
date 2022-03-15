<?php
namespace Pantheon\EI\Consent;

use PHPUnit\Framework\TestCase;

class testsMain extends TestCase {
	public function testWPConsentAPIisLoaded() {
		$this->assertFalse( class_exists( 'WP_CONSENT_API' ) );
		// Run the maybe_require_wp_consent_api function and maybe require it.
		maybe_require_wp_consent_api();
		$this->assertTrue( class_exists( 'WP_CONSENT_API' ) );
	}
}
