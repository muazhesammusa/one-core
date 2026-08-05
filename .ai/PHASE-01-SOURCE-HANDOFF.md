# Phase 1 Follow-up — Source Handoff [complete]

Status: [complete]
Date: 2026-08-06

## Command

```bash
npm run build:zip
```

## Output

```text
$TMPDIR/one-source-handoff/one-core-latest.zip
$TMPDIR/one-source-handoff/one-core-latest.zip.sha256
```

The stable output directory is resolved through Node's `os.tmpdir()`, which uses the macOS system temp location. Building one project does not delete the other project's handoff archive.

The archive is intended for development handoff. It includes the current Core source, tests, scripts, package metadata, `AGENTS.md`, and `.ai/` tracking files. Generated release trees, dependencies, repositories, caches, previous archives, and operating-system junk are excluded.
