var Pantheon=window.Pantheon||{};Pantheon.Consent={giveConsentButton:document.querySelector(".give-consent"),revokeConsentButton:document.querySelector(".revoke-consent"),updatedMessage:document.querySelector(".cookie-consent-banner__updated"),closeUpdated:document.querySelector(".cookie-consent-banner__updated-close"),consentBanner:document.querySelector(".cookie-consent-banner")},Pantheon.Consent.cookieSaved=function(){let e=!1;return wp_has_consent("marketing")&&(e=!0),e},Pantheon.Consent.updateConsent=function(){"give-consent"===this.className&&wp_set_consent("marketing","allow"),"revoke-consent"===this.className&&wp_set_consent("marketing","deny"),document.querySelector(".cookie-consent-banner").classList.add("hide"),Pantheon.Consent.showUpdatedMessage()},Pantheon.Consent.maybeDisplayBanner=function(){!Pantheon.Consent.cookieSaved()&&Pantheon.Consent.consentBanner&&(Pantheon.Consent.consentBanner.style.display="block")},Pantheon.Consent.showUpdatedMessage=function(){document.querySelector(".cookie-consent-banner__updated").classList.toggle("show")},Pantheon.Consent.maybeDisplayBanner(),Pantheon.Consent.giveConsentButton.addEventListener("click",Pantheon.Consent.updateConsent),Pantheon.Consent.revokeConsentButton.addEventListener("click",Pantheon.Consent.updateConsent),Pantheon.Consent.closeUpdated.addEventListener("click",(()=>Pantheon.Consent.showUpdatedMessage.toggle("show")));