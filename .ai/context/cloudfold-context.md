# CloudFold Pro - Master Project Context & Design Guidelines

## 1. Project Identity & Purpose
**CloudFold Pro** is an advanced, high-performance WordPress plugin for digital asset management and gallery creation. It targets professional photographers and site builders who expect a premium, modern SaaS-like experience (similar to Stripe, Linear, Vercel, or macOS). The core design philosophy is "Clean, Glassy, Soft & Deep" with absolutely zero visual clutter.

## 2. Core Technology Stack & Strict Rules
- **Frontend (User-facing):** STRICTLY Vanilla JavaScript (ES6+). **ABSOLUTELY NO jQuery.**
- **Backend/Admin (Dashboard & Blocks):** React.js (via Vite build process), standard WordPress Gutenberg Block API components.
- **Styling:** Modular CSS/SCSS (No inline styling unless dynamic). Follow a strict utility/component-based approach.
- **REST API:** All client-to-server communication happens via `/wp-json/cloudfold/v1/` endpoints. Avoid generic `admin-ajax.php` where REST API is more appropriate.

## 3. Design System & UI/UX Principles
When creating or updating UI components, you must adhere to the following design system:
- **Component Architecture:** Always build modular React components. Check `admin/js/src/components/ui/` before creating a new generic element (e.g., use existing `<Spinner />`, `<Toast />`, `<EmptyState />`).
- **Typography:** Clean, sans-serif hierarchy. Maintain clear visual distinction between Heading (bold, larger) and Body text (regular, 14px/16px).
- **Spacing & Rhythm:** Follow an 8px grid system (8, 16, 24, 32, 48px). Ensure consistent padding inside cards and margins between sections to maintain perfect visual flow.
- **Colors & States:** - Primary Buttons: Solid brand color background with white text.
  - Secondary/Cancel Buttons: Outline or subtle gray background.
  - Hover/Focus States: Every interactive element must have a clear hover and `:focus-visible` state.

## 4. The 7 Core Gallery Layouts
Do not mix the HTML/CSS logic of these layouts. Each has a specific visual structure:
1. **Masonry:** Pinterest-style. Columns of fixed width but images have variable heights.
2. **Justified Grid:** Flickr-style. Rows of equal height; images are scaled to perfectly fill the horizontal space.
3. **Grid:** Standard strict grid. Equal width and equal height (usually cropped) thumbnails.
4. **Metro:** Mosaic/Magazine style. A complex grid with spanning items.
5. **Carousel:** Continuous horizontal scrolling or swiping items.
6. **Slider:** Hero-style single item view with next/prev arrows and dot pagination.
7. **Custom CSS:** User-defined layout where base styling is stripped back.

## 5. Performance & Optimization Standards
- **Lazy Loading:** Must use the native `Intersection Observer` API for deferring image and video loads.
- **Image Serving:** Always utilize native WordPress `srcset` attributes. Prioritize WebP format outputs.
- **DOM Manipulation:** Keep DOM writes minimal and batched for high performance on the frontend.

## 6. AI & Smart Features Integration
- **Auto Alt Text:** Powered by OpenAI (GPT-4o) or Anthropic (Claude). This requires checking for valid API keys in settings. Always handle API loading states with visual feedback (Spinners/Progress bars) and catch errors gracefully via UI Toasts.
- **Background Processes:** Heavy tasks (like bulk WebP conversion or bulk AI processing) must be handled asynchronously with clear UI progress indicators.

## 7. Standard Output Formats (WordPress)
- **Shortcodes:**
  - Standard Gallery: `[cloudfold_gallery id="X"]`
  - Album Collection: `[cloudfold_album id="X"]`
- **Gutenberg Blocks:** Must support standard block alignment (wide, full-width) and integrate seamlessly with the Site Editor (FSE).

## 8. AI Agent Instructions (How to behave)
- **Ask Before Guessing:** If the user asks for a UI component, build it using the established Design System. If unsure about a color or spacing rule, ask or refer to standard WordPress UI components.
- **Zero jQuery Tolerance:** If you output jQuery code (`$()`), you have failed the prompt. Use `document.querySelector` and vanilla DOM events.
- **Be Consistent:** Stick to the established file structure (e.g., React components go in `admin/js/src/components/`, PHP classes go in `includes/`).