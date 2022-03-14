var Pantheon = window.Pantheon || {};

Pantheon.Consent = {
	giveConsentButton: document.querySelector('.give-consent'),
	revokeConsentButton: document.querySelector('.revoke-consent'),
	updatedMessage: document.querySelector('.cookie-consent-banner__updated'),
	closeUpdated: document.querySelector('.cookie-consent-banner__updated-close'),
	consentBanner: document.querySelector('.cookie-consent-banner'),
};

Pantheon.Consent.cookieSaved = function () {
	let consentExists = false;
	if ( wp_has_consent( 'marketing' ) ) {
		consentExists = true;
	}

	return consentExists;
}

Pantheon.Consent.updateConsent = function () {
	if ( this.className === 'give-consent' ) {
		wp_set_consent( 'marketing', 'allow' );
	}

	if ( this.className === 'revoke-consent' ) {
		wp_set_consent( 'marketing', 'deny' );
	}

	document.querySelector( '.cookie-consent-banner' ).classList.add( 'hide' );

	Pantheon.Consent.showUpdatedMessage();
}

Pantheon.Consent.maybeDisplayBanner = function () {
	if (
		! Pantheon.Consent.cookieSaved() &&
		Pantheon.Consent.consentBanner
	) {
		Pantheon.Consent.consentBanner.style.display = 'block';
	}
}

Pantheon.Consent.showUpdatedMessage = function () {
	const consentUpdated = document.querySelector( '.cookie-consent-banner__updated').classList;
	consentUpdated.toggle( 'show' );
}

Pantheon.Consent.maybeDisplayBanner();
Pantheon.Consent.giveConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.revokeConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.closeUpdated.addEventListener( 'click', () => Pantheon.Consent.showUpdatedMessage.toggle( 'show' ) );