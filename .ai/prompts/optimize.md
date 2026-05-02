# Optimize

Optimize this codebase change for real-world performance in a WordPress plugin UI (React admin + PHP backend).

Tasks:
- Reduce unnecessary renders and state churn (especially Logs/Run history/Editor).
- Improve algorithm efficiency for any list/filter/sort paths.
- Minimize bundle size (avoid new deps, prefer existing utilities).
- Keep UX stable (no flicker, no fetch loops, no scroll regressions).

Inputs you should expect:
- A code snippet or file path(s) to optimize
- A symptom: “slow navigation”, “jank”, “scroll stutter”, “many network calls”

Constraints:
- Don’t add new runtime libraries unless already used in the repo.
- Don’t log secrets or add debug logging.
- Keep behavior identical unless explicitly requested.

Workflow:
1) Identify bottlenecks
   - Find repeated renders/mounts, unstable callbacks, effects without stable deps.
   - Find heavy CSS effects (blur/backdrop-filter, big shadows, transition: all).
   - Find excessive network polling or redundant fetches.
2) Apply targeted optimizations
   - Memoize expensive derived data (useMemo) and stable callbacks (useCallback).
   - Split large UI into memoized subcomponents when it reduces re-render surface.
   - Prefer CSS-only changes for layout stability; avoid DOM measurement loops.
   - Add “perf mode” / reduced motion fallbacks for heavy visuals when applicable.
3) Validate
   - Confirm no regressions in scrolling and navigation.
   - Confirm request count doesn’t explode (watch Network for repeated calls).

Deliverables:
- A short summary of what was slow and why.
- A patch with minimal, readable changes.
- Notes on how to verify in browser (what to look at in DevTools).

Verification checklist (repo defaults):
- Run: composer run lint:php
- Run: vendor/bin/phpunit --testdox
- Run: npm run build
