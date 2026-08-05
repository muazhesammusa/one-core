# Phase 01 — Legacy License Cleanup

Status: Complete
Date: 2026-08-06

## Removed from One Core

- Custom `OneThemeUpdater` runtime and browser asset.
- One Core bootstrap include for the custom updater.
- Dead `One_Imports_Controllers.php` implementation that coupled templates and theme updates to old license options.
- Obsolete CAPTCHA document describing an API client not present in this source.

## Preserved

- One Core widgets and assets.
- Existing demo importer bootstrap.
- Existing extension export behavior.
- All frontend companion functionality.

## Validation contract

Run:

```bash
php tests/legacy-license-cleanup-contract.php
```
