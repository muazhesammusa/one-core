# FRONTEND ARCHITECTURE RULES

---

# STACK (MANDATORY)

- React 18+
- Next.js 14+ (App Router)
- TailwindCSS (latest)
- TypeScript

---

# COMPONENT DESIGN

- Functional components only
- Use hooks (no class components)
- Split large components

Structure:

/components/ui/
/components/layout/
/features/{feature}/

---

# STATE MANAGEMENT

- Local state → useState
- Complex → useReducer
- Global → Zustand / Context (minimal)

---

# PERFORMANCE

- Use dynamic import
- Use memoization where needed
- Avoid unnecessary re-renders

---

# STYLING

- Tailwind only
- No inline styles
- No CSS frameworks mix

---

# FILE NAMING

- kebab-case for folders
- PascalCase for components

---

# CODE QUALITY

- Clean, readable, modular
- No duplicate logic
- Reusable hooks/components

---

# FORBIDDEN

- jQuery
- Inline CSS
- Monolithic components
- Unoptimized renders

---

# OUTPUT

AI must generate:

- Production-ready React components
- Scalable architecture
- Clean Tailwind UI