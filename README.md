# Pantheon Edge Integrations Consent Management

Stable tag: 0.1.7  
Requires at least: 5.8  
Tested up to: 5.9  
Requires PHP: 7.4  
License: MIT  
Tags: pantheon, personalization, edge integrations, consent, developer
Contributors: jazzs3quence, getpantheon

Implements [WP Consent API](https://github.com/rlankhorst/WP-Consent-Level-API) into [Pantheon Edge Integrations](https://pantheon.io/docs/guides/edge-integrations) to manage consent and data tracking. 

[![Unsupported](https://img.shields.io/badge/pantheon-unsupported-yellow?logo=pantheon&color=FFDC28)](https://pantheon.io/docs/oss-support-levels#unsupported) ![Pantheon Edge Integrations Consent Management](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/actions/workflows/test.yml/badge.svg) [![GitHub release](https://img.shields.io/github/release/pantheon-systems/pantheon-edge-integrations-consent-management.svg)](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/releases/)

## Description

This plugin provides an interface for managing cookie consent with Edge Integrations: Personalization for WordPress. It's built using the [WP Consent API](https://github.com/rlankhorst/WP-Consent-Level-API) feature plugin to manage consent levels and registers the cookies & local storage data with the Consent API.

A banner is displayed if no consent has been given yet. The interest and geo tracking functionality does not operate until consent is given. If consent is revoked, neither form of tracking will be active.

In addition, suggested text is provided on the Privacy page in the admin to add to your site's privacy or cookie policy page.

### How it works

The WP Consent API adds a programmatic interface to manage and track a user's consent level for cookies and other forms of local storage frequently used for storing user preferences, tracking information, etc. It does this by establishing a range of cookie categories (described in the [Frequently Asked Questions](https://github.com/rlankhorst/wp-consent-level-api#frequently-asked-questions) like statistics, marketing and functional.

This plugin adds an integration with the Consent API library to manage the cookies and local storage created and used by the [Pantheon WordPress Edge Integrations](https://github.com/pantheon-systems/pantheon-wordpress-edge-integrations) plugin. For the purposes of this plugin, all cookies and local storage created by Pantheon WordPress Edge Integrations plugin are considered "marketing" cookies and flagged as such in the code when those cookies are [registered with the API](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/inc/namespace.php#L54-L82).  

The JavaScript file included in the plugin toggles whether a [cookie consent banner is rendered](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/assets/js/main.js#L45-L55) depending on whether a WP Consent API marketing consent cookie exists. [JavaScript event listeners](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/assets/js/main.js#L71-L72) wait for one of the two buttons -- either Allow All Cookies or Allow Only Functional Cookies -- are clicked. If Allow All Cookies is clicked, [the consent level is set to _allow_ marketing cookies](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/assets/js/main.js#L34-L36). If Allow Only Functional Cookies is clicked, [the consent level is set to _deny_ marketing cookies](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/assets/js/main.js#L38-L40).

The PHP code then checks for consent for "marketing" cookies. If consent has not been given, it makes two adjustments to the Pantheon WordPress Edge Integrations plugin, rendering the Edge Integrations functions inoperable until consent is given:

1. The `pantheon.ei.supported_vary_headers` filter is used to [set all Edge Integrations vary headers to false](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/inc/namespace.php#L99-L111), so no headers are sent to AGCDN. This ensures that the user's preferences are respected by not sending any personalization data to our edge servers.
2. The `pantheon.ei.post_types` filter is used to [set the allowed post type(s) to a non-existant post type (`none`)](https://github.com/pantheon-systems/pantheon-edge-integrations-consent-management/blob/main/inc/namespace.php#L113-L121). This ensures that interest tracking is not stored at all, since none of the content a user would be visiting would be in an allowed post type.

### Extending the Plugin

This plugin is just a functional example of how to manage consent with Edge Integrations. The code can be forked and expanded for more robust consent management. More consent categories can be supported than just "marketing" and hooks can be added to allow the categories to be filterable, the `none` post type to be modified, etc. Additionally, the consent banner can be modified to support more granular selection of consent categories as part of a more robust consent management solution, and the content of the banner could be hooked to an options page where it is editable by site owners.

<!-- changelog -->