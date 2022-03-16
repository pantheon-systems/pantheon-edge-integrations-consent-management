# Pantheon Edge Integrations Consent Management

Stable tag: 0.1.3  
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

<!-- changelog -->