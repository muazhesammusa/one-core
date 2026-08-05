# One Core Engineering Guide

## Product boundary

One Core is the companion plugin for the One WordPress theme. It provides widgets, integrations, demo-import support, and theme companion functionality. It does not own the commercial license lifecycle or the theme updater.

## License migration rules

- Follow `.ai/ONE_LICENSE_MIGRATION_PLAN.md` in phase order.
- Never add a theme updater, activation screen, purchase-code verifier, license storage, or package installer to One Core.
- Never restore the removed `updater/` implementation or `One_Imports_Controllers.php` legacy license/update coupling.
- Consume entitlement only through the stable bridge exposed by the One theme.
- One Core must remain loadable when the theme license client is unavailable or inactive.

## Change discipline

- Keep licensing work separate from widgets, importer rendering, and frontend compatibility work.
- Add a contract test for architecture boundaries.
- Avoid hardcoded product secrets and raw license values.
- Keep source and shipped assets synchronized.
- Deliver changed-files-only patches with checksums and deletion manifests.

## Source handoff

Run `npm run build:zip` from the One Core root when a fresh source snapshot is needed. It creates `one-core-latest.zip` inside the macOS system temp directory (`$TMPDIR/one-source-handoff/`) and opens that folder in Finder; do not manually zip `release/`, `.git/`, or `node_modules/`.
## Phase 3 license UI rules

- Keep activation, refresh, deactivation, purchase-code handling, and license admin assets in the One theme only.
- Every license mutation requires `manage_options` and the `one_license_admin` AJAX nonce.
- Never persist, log, localize, or return a raw purchase code.
- Keep license JavaScript and CSS scoped to `One → License`.
- Mark completed migration phases with `[complete]` in `.ai/ONE_LICENSE_MIGRATION_PLAN.md`.

