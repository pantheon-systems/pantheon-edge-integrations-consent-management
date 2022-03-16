var Pantheon = window.Pantheon || {};

/**
 * Set up some variables.
 */
Pantheon.Consent = {
	giveConsentButton: document.querySelector('.give-consent'),
	revokeConsentButton: document.querySelector('.revoke-consent'),
	updatedMessage: document.querySelector('.cookie-consent-banner__updated'),
	closeUpdated: document.querySelector('.cookie-consent-banner__updated-close'),
	closeBanner: document.querySelector('.cookie-consent-banner__inner__button.close'),
	consentBanner: document.querySelector('.cookie-consent-banner'),
	consentMessage: document.querySelector('.cookie-consent-banner__inner'),
};

/**
 * Check if consent has been given for marketing cookies.
 *
 * @returns {Boolean}
 */
Pantheon.Consent.cookieSaved = function () {
	let consentExists = false;
	if ( wp_has_consent( 'marketing' ) ) {
		consentExists = true;
	}

	return consentExists;
}

/**
 * Update the consent status on button click for marketing cookies and display an updated message.
 */
Pantheon.Consent.updateConsent = function () {
	if ( this.classList.contains( 'give-consent' ) ) {
		wp_set_consent( 'marketing', 'allow' );
	}

	if ( this.classList.contains( 'revoke-consent' ) ) {
		wp_set_consent( 'marketing', 'deny' );
	}

	Pantheon.Consent.showUpdatedMessage();
}

/**
 * Display the banner if consent has not been given.
 */
Pantheon.Consent.maybeDisplayBanner = function () {
	if (
		! Pantheon.Consent.cookieSaved() &&
		Pantheon.Consent.consentBanner
	) {
		Pantheon.Consent.consentBanner.style.display = 'grid';
	}
}

/**
 * Display the updated message.
 */
Pantheon.Consent.showUpdatedMessage = function () {
	const consentUpdated = document.querySelector( '.cookie-consent-banner__updated');
	consentUpdated.style.display = 'grid';
	Pantheon.Consent.consentMessage.style.display = 'none';

}

// Do all the things!
Pantheon.Consent.maybeDisplayBanner();

// Listen for button clickes.
Pantheon.Consent.giveConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.revokeConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.closeUpdated.addEventListener( 'click', () => {
	Pantheon.Consent.consentBanner.style.display = 'none';
} );
Pantheon.Consent.closeBanner.addEventListener( 'click', () => {
	Pantheon.Consent.consentBanner.style.display = 'none';
} );