---
paths:
  - "src/api/**/*.ts"
  - "src/api/**/*.js"
  - "**/RestController.php"
---

# API Rules

## Design
- RESTful structure
- Consistent response format

## Response Format
{
  success: boolean,
  data: any,
  error: string | null
}

## Validation
- Validate all inputs
- Return clear error messages

## Performance
- Avoid unnecessary queries
- Use pagination for lists