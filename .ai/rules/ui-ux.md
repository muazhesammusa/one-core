# UI / UX RULES (MODERN PREMIUM DESIGN SYSTEM)

---

# CORE DESIGN PRINCIPLES

- Clean, minimal, premium UI
- High readability + strong hierarchy
- No clutter, no unnecessary elements
- Focus on usability + speed

---

# DESIGN STYLE (MANDATORY)

- Modern SaaS dashboard style
- Inspired by:
  - Linear
  - Vercel
  - Stripe
  - Notion

---

# LAYOUT RULES

- Use spacing-based layout (NOT borders)
- Prefer grid + flex (no absolute hacks)
- Max container width: 1280px – 1440px
- Use consistent padding scale (8px system)

Example spacing scale:
4 / 8 / 12 / 16 / 24 / 32 / 48 / 64

---

# COLOR SYSTEM

- Use neutral base (gray scale)
- Use 1 primary accent color
- Optional: 1 secondary accent

Rules:

- No random colors
- Maintain contrast (WCAG AA minimum)
- Dark mode must be supported

Example:

Primary: Indigo / Blue / Purple
Success: Green (soft)
Error: Red (soft)
Warning: Amber

---

# TYPOGRAPHY

- Font: Inter / Geist / System UI
- Base size: 14px – 16px
- Headings: tight, bold, compact

Hierarchy:

- H1 → 28–32px
- H2 → 22–24px
- H3 → 18–20px
- Body → 14–16px

---

# COMPONENT RULES

## Buttons

- Rounded-md (8px)
- No heavy shadows
- Subtle hover + active states
- Use variants:

primary / secondary / ghost / danger

---

## Cards

- Soft background contrast
- Border: subtle (1px, neutral)
- Padding: 16–24px
- Radius: 12–16px

---

## Inputs

- Clean, minimal
- Focus ring (primary color)
- No heavy borders

---

## Tables

- Clean row separation
- No vertical borders
- Hover highlight row

---

# INTERACTION RULES

- Use subtle animations
- Duration: 150ms – 300ms
- Use easing (ease-out)

Examples:

- hover scale: 1.01
- fade transitions
- smooth dropdowns

---

# ANIMATION RULES

- Use GSAP or CSS transitions
- Avoid heavy animations
- Keep performance optimized

---

# RESPONSIVE RULES

Breakpoints:

- sm: 640px
- md: 768px
- lg: 1024px
- xl: 1280px

Rules:

- Mobile-first design
- Collapse sidebars
- Stack components vertically

---

# ACCESSIBILITY

- Must support keyboard navigation
- Focus states required
- ARIA where needed

---

# DARK MODE

- Mandatory
- Use class-based toggle
- Avoid pure black (#000)
- Use dark gray scale

---

# ICON SYSTEM

- Use consistent icon set (Lucide / Heroicons / svg icons)
- Size: 16 / 20 / 24
- Stroke-based preferred

---

# FORBIDDEN

- Bootstrap look-alike UI
- Overuse of shadows
- Random gradients
- Inconsistent spacing
- Mixed font systems

---

# OUTPUT EXPECTATION

AI must generate:

- Clean component structure
- TailwindCSS styling
- No inline styles
- Hybrid styling
- Reusable components
- Scalable layout system

If UI is not premium → output is INVALID