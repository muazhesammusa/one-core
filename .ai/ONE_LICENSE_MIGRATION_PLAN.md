# One License Migration Plan — One Core View

Last updated: 2026-08-06

The One theme is the licensing owner. One Core is an entitlement consumer only.

- Phase 1: Legacy License and Updater Cleanup [complete]
- Phase 1.1: Source Handoff Tooling [complete]
- Phase 2: Theme-side License Client Foundation / no Core runtime [complete]
- Phase 3: Activation Lifecycle UI / no Core ownership [complete]
- Phase 4: Defensive Entitlement Bridge Consumer [complete]
- Phase 5: Native Theme Updater / no Core ownership [complete]
- Phase 6: Remaining Core-side Legacy Assumption Cleanup [complete]
- Phase 7: Licensed and Unlicensed Compatibility QA [complete]
- Phase 8: Production License Go-Live Integration / no Core ownership [complete]

## Permanent boundary

One Core must not register theme update transients, download theme packages, store purchase codes, or call licensing endpoints directly. Any protected Core feature must query the One theme bridge and fail open for frontend rendering.

## Phase 1 follow-up — source handoff tooling

Status: [complete]

- `npm run build:zip` creates `$TMPDIR/one-source-handoff/one-core-latest.zip` from the current Core source.
- Generated release copies, repositories, dependencies, caches, and prior ZIP files are excluded.
- The legacy-cleanup contract ignores generated `release/` and `temp/` trees, preventing self-matches after a release build.
- On macOS, a successful `npm run build:zip` opens the output folder in Finder.


## Production go-live integration

Phase 8 preserves the permanent boundary: One Core remains an entitlement consumer only. Release and source-handoff builders exclude generated `release/` and `temp/` trees, and One Core does not receive product keys, API transport, entitlement verification, or update ownership.
