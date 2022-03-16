<?php
/**
 * Consent Updated Message
 *
 * @package Pantheon/EdgeIntegrations/ConsentManagement
 */

?>
<div class="cookie-consent-banner__updated">
	<p>
		<span class="cookie-consent-banner__updated__message">
			<?php esc_html_e( 'Cookie preferences updated.', 'pantheon-edge-integrations-consent-management' ); ?>
		</span>
	</p>
	<button class="cookie-consent-banner__updated-close close">
			<span class="screen-reader-text">
				<?php esc_html_e( 'Close', 'pantheon-edge-integrations-consent-management' ); ?>
			</span>
			<span class="dashicons dashicons-no-alt"></span>
		</button>
</div>
