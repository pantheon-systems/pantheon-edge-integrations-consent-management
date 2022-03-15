var Pantheon = window.Pantheon || {};

Pantheon.Consent = {
	giveConsentButton: document.querySelector('.give-consent'),
	revokeConsentButton: document.querySelector('.revoke-consent'),
	updatedMessage: document.querySelector('.cookie-consent-banner__updated'),
	closeUpdated: document.querySelector('.cookie-consent-banner__updated-close'),
	closeBanner: document.querySelector('.cookie-consent-banner__inner__button.close'),
	consentBanner: document.querySelector('.cookie-consent-banner'),
	consentMessage: document.querySelector('.cookie-consent-banner__inner'),
};

Pantheon.Consent.cookieSaved = function () {
	let consentExists = false;
	if ( wp_has_consent( 'marketing' ) ) {
		consentExists = true;
	}

	return consentExists;
}

Pantheon.Consent.updateConsent = function () {
	if ( this.classList.contains( 'give-consent' ) ) {
		wp_set_consent( 'marketing', 'allow' );
	}

	if ( this.classList.contains( 'revoke-consent' ) ) {
		wp_set_consent( 'marketing', 'deny' );
	}

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
	const consentUpdated = document.querySelector( '.cookie-consent-banner__updated');
	consentUpdated.style.display = 'grid';
	Pantheon.Consent.consentMessage.style.display = 'none';

}

Pantheon.Consent.maybeDisplayBanner();
Pantheon.Consent.giveConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.revokeConsentButton.addEventListener( 'click', Pantheon.Consent.updateConsent );
Pantheon.Consent.closeUpdated.addEventListener( 'click', () => {
	Pantheon.Consent.consentBanner.style.display = 'none';
} );
Pantheon.Consent.closeBanner.addEventListener( 'click', () => {
	Pantheon.Consent.consentBanner.style.display = 'none';
} );