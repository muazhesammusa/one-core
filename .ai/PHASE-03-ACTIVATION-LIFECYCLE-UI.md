# Phase 3: Activation Lifecycle UI [complete]

Completed: 2026-08-06
Owner: One theme; One Core boundary verified

## Delivered

- Added a dedicated `One → License` dashboard route.
- Added capability- and nonce-protected AJAX activation, refresh, and deactivation.
- Added purchase-code masking and request-only handling; the raw code is never stored by the theme.
- Added signed entitlement verification before any successful state is saved.
- Added route-scoped admin CSS and JavaScript with accessible status feedback.
- Added per-user action throttles and explicit temporary-error handling.
- Added configuration readiness checks for Sodium and trusted Ed25519 public keys.
- Kept One Core free of license UI, API transport, and secret handling.

## Boundary

This phase does not add the One Core entitlement bridge or native WordPress theme updater. Those remain Phase 4 and Phase 5.
