<?php
/**
 * Consent Banner
 *
 * @package Pantheon/EdgeIntegrations/ConsentManagement
 */

?>
<div class="cookie-consent-banner">
	<?php load_template( __DIR__ . '/part-updated.php' ); ?>
	<div class="cookie-consent-banner__inner">
		<div class="cookie-consent-banner__inner__message">
			<?php
			echo wp_kses_post(
				'<p>' .
				sprintf(
					/* translators: %s: The name of the plugin. */
					__( 'This site uses cookies to improve your experience. By continuing to use this site, you agree to our use of cookies. %s', 'pantheon-edge-integrations-consent-management' ),
					'<a href="' . esc_url( get_permalink( get_page_by_path( 'privacy-policy' ) ) ) . '">' . esc_html__( 'Learn more', 'pantheon-edge-integrations-consent-management' ) . '</a>'
				) .
				'</p>'
			);
			?>
		</div>
		<button class="cookie-consent-banner__inner__button give-consent">
			<?php esc_html_e( 'Accept all cookies', 'pantheon-edge-integrations-consent-management' ); ?>
		</button>
		<button class="cookie-consent-banner__inner__button revoke-consent">
			<?php esc_html_e( 'Accept only functional cookies', 'pantheon-edge-integrations-consent-management' ); ?>
		</button>
		<button class="cookie-consent-banner__inner__button close">
			<span class="screen-reader-text">
				<?php esc_html_e( 'Close', 'pantheon-edge-integrations-consent-management' ); ?>
			</span>
			<span class="dashicons dashicons-no-alt"></span>
		</button>
	</div>
</div>