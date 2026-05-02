# 🔥 WordPress Plugin Rules (CloudFold)

## Core Principles
- Follow WordPress Coding Standards
- Use proper prefix (cloudfold_)
- Escape all outputs (esc_html, esc_attr, wp_kses)
- Sanitize all inputs
- Nonce verification required for forms

## PHP Architecture
- Modular structure (includes/, admin/, frontend/)
- No logic in templates
- Use hooks (actions/filters)
- Avoid global variables

## Database
- Use $wpdb safely
- Use prepare() for queries
- Avoid unnecessary queries

## Security
- Prevent direct file access (ABSPATH check)
- Validate AJAX requests
- Capability checks (current_user_can)

## React Admin (Vite)
- Use TypeScript
- Modular components
- Avoid unnecessary re-renders
- Use lazy loading
- Keep bundle optimized

## Performance
- Minimize asset load
- Load scripts conditiona- Lo- Us- Lochi- Load scripts le- Load scripts conditiona- Lo- Us- Lochi- Load scriptpla- Load scripts conditionOF


 Load scripts conditiona- Lo � Load scripts conditiona- =====================
cat << 'EOF' > ai/context/cloudfold-context.md
# 📦 CloudFold Plugin Context

## Type
WordPress Plugin with React Admin (Vite)


ordPress Plugin with React  apordPress Plugin with React  apordPress Plugin wi)
- /assets (CSS/JS)

## Features
- Gallery Builder
- Layout syste- Layout syste- Laslider)
- Gutenberg Block
- Media Organizer

## Goals
- High performance
- Modular architecture
- Scalable feature system
- Plugin marketplace ready

## Notes
- React handles admin UI
- PHP handles backend logic
- REST API / AJAX bridge required
