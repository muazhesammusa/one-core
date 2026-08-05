# One License Migration Plan — One Core View

Last updated: 2026-08-06

The One theme is the licensing owner. One Core is an entitlement consumer only.

| Phase | One Core responsibility | Status |
|---|---|---|
| 1 | Remove custom updater and dead license-coupled controller | Complete |
| 2 | No license client implementation | Pending theme work |
| 3 | No activation UI implementation | Pending theme work |
| 4 | Consume the theme entitlement bridge defensively | Pending |
| 5 | No updater ownership | Pending theme work |
| 6 | Remove any remaining Core-side legacy state assumptions | Pending |
| 7 | Validate Core with licensed, unlicensed, offline, and inactive-theme-client states | Pending |

## Permanent boundary

One Core must not register theme update transients, download theme packages, store purchase codes, or call licensing endpoints directly. Any protected Core feature must query the One theme bridge and fail open for frontend rendering.

## Phase 1 follow-up — source handoff tooling

Status: Complete

- `npm run build:zip` creates `$TMPDIR/one-source-handoff/one-core-latest.zip` from the current Core source.
- Generated release copies, repositories, dependencies, caches, and prior ZIP files are excluded.
- The legacy-cleanup contract ignores generated `release/` and `temp/` trees, preventing self-matches after a release build.
