# CloudFold Pro - UI & Design System Rules

## 1. Design Philosophy: "Clean, Glassy & Deep"
CloudFold Pro UI is modeled after top-tier modern SaaS platforms (like Stripe, Vercel, Linear) and modern macOS aesthetics. It relies on subtle depth, translucency, soft geometry, and clean typography. It absolutely rejects flat, harsh, boxed, or cluttered interfaces.

## 2. Soft Geometry (Border Radii)
ABSOLUTELY NO sharp corners (`0px`).
- **Small Elements (Inputs, Badges, Checkboxes, small buttons):** `8px` (`--pix-radius-sm`) to `10px`.
- **Medium Elements (Standard Buttons, Tabs, Dropdowns, Toolbars):** `12px` (`--pix-radius-md`).
- **Large Elements (Cards, Modals, Editor shells, Images):** `14px` to `18px` (`--pix-radius-lg`).
- **Pills/Toggles/Count Badges:** `999px` (Fully rounded).

## 3. Glassmorphism & Depth (Borders and Backgrounds)
Do not use harsh solid hex colors for borders or panels. Use CSS `color-mix()` and alpha channels.
- **Subtle Borders:** Default to `border: 1px solid color-mix(in srgb, var(--pix-border) 80%, transparent);`
- **Glass Backgrounds:** Use `radial-gradient` mixes or `backdrop-filter: blur(8px)` to let underlying content bleed through slightly.
- **Hover Borders:** On hover, borders should subtly shift to a translucent primary brand color (e.g., `hsl(var(--brand-h) var(--brand-s) var(--brand-l) / 0.35)`).

## 4. Shadows (Layering)
Elements must feel like they are floating above the canvas.
- **Resting state (Cards, Items):** `var(--pix-shadow-sm)`
- **Hover state (Cards):** `var(--pix-shadow-md)`
- **Elevated (Modals, Drawers, Floating Bars, Tooltips):** `var(--pix-shadow-lg)`

## 5. Focus & Interactive States
- **Focus Rings:** NEVER use the default browser `outline`. 
- **Strict Focus Pattern:** `box-shadow: 0 0 0 3px var(--pix-ui-ring);` (macOS style focus ring, typically a 10%-15% opacity of the primary color).
- **Active/Pressed State:** Buttons and interactive cards should "press down" slightly: `transform: translateY(1px) scale(0.98);`.

## 6. Premium Dark Mode Rules (`[data-cloudfold-theme="dark"]`)
- **Base Background:** Deep, rich navy/indigo (`hsl(228 28% 8%)`). NEVER use pure black `#000000`.
- **Surfaces:** Elevated panels use `hsl(228 24% 12%)` and `hsl(228 20% 16%)`.
- **Borders in Dark Mode:** Subtle and visible, typically `hsl(228 16% 22%)`.
- **Text in Dark Mode:** Use off-white `hsl(220 20% 94%)` for primary text and `hsl(218 14% 56%)` for muted text to prevent eye strain.

## 7. Spacing & Typography
- **Grid System:** Strict adherence to an 8px base grid (`8px`, `12px`, `16px`, `24px`, `32px`, `48px`).
- **Typography:** Rely on modern system UI fonts (`Inter`, `-apple-system`, `BlinkMacSystemFont`).
- **Hierarchy:** - Titles/Headings must be heavy and crisp (`font-weight: 800` or `900`, `letter-spacing: -0.02em`).
  - Descriptions and meta text should be subtle and smaller (`color: var(--pix-muted)`, `font-weight: 600` or `700`, `12px` or `13px`).