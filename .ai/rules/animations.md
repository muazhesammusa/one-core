# CloudFold Pro - Motion & Animation Design Tokens

## 1. Core Animation Philosophy
CloudFold Pro requires a **"Snappy, Weightless, and Premium"** feel. Animations must never feel sluggish, dragging, bouncy in a cheap way, or generic. 

**STRICT RULE:** NEVER use `transition: all`. You must explicitly target properties (e.g., `transition: transform 150ms ease, opacity 150ms ease`).

## 2. Micro-interactions (Hovers, Focus, Buttons, Toggles)
These must feel instantaneous but smooth.
- **Timing:** `140ms` to `160ms` (Default to `150ms`).
- **Easing:** `ease` or `linear` for color changes.
- **Behavior Patterns:**
  - **Buttons/Cards Hover:** Subtle lift `transform: translateY(-1px)` or `translateY(-2px)`.
  - **Image Hover Zoom:** Smooth scale `transform: scale(1.04)` or `scale(1.05)`.
  - **Shadow Shift:** Increase shadow depth seamlessly (e.g., transition resting shadow to `var(--pix-shadow-md)`).

## 3. Macro-interactions (Modals, Drawers, Image Expansion, Layout Shifts)
These require a high-end "Spring" or "Snappy" feel, entering the screen incredibly fast and settling smoothly into place.
- **Timing:** `180ms` to `320ms` (Default to `.22s` or `220ms`).
- **Easing (The CloudFold Signature Curve):** STRICTLY use `cubic-bezier(.22, 1, .36, 1)`.
- **Behavior Patterns:**
  - **Drawers Entering:** `transform: translateX(0)` from `100%`.
  - **Lightbox/Modals:** Scale up from `0.95` to `1` combined with an opacity fade from `0` to `1`.
  - **Floating Action Bars:** `transform: translateY(-8px)` to `0` using the signature snappy curve.

## 4. CSS Implementation Examples
When generating CSS, use these exact patterns:

```css
/* Card Hover Micro-interaction */
.cloudfold-card {
  transition: transform 160ms ease, box-shadow 160ms ease, border-color 160ms ease;
}
.cloudfold-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--pix-shadow-md);
}

/* Image Zoom with Signature Snappy Curve */
.cloudfold-img-thumb img {
  transition: transform .32s cubic-bezier(.22, 1, .36, 1);
}
.cloudfold-img-card:hover .cloudfold-img-thumb img {
  transform: scale(1.05);
}

/* Drawer / Modal Entry Animation */
@keyframes pn-drawer-in {
  from { transform: translateX(100%); opacity: 0; }
  to   { transform: translateX(0);    opacity: 1; }
}
.cloudfold-drawer {
  animation: pn-drawer-in .22s cubic-bezier(.22, 1, .36, 1);
}