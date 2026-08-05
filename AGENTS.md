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

Run `npm run build:zip` from the One Core root when a fresh source snapshot is needed. Share the `one-core-latest.zip` created inside the macOS system temp directory (`$TMPDIR/one-source-handoff/`); do not manually zip `release/`, `.git/`, or `node_modules/`.
