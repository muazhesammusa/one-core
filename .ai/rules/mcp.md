---
paths:
  - "mcp/**/*.php"
  - "**/McpServer.php"
---

# MCP Rules

## Core Rule
ALWAYS prefer tool execution over text output.

## Tool Behavior
- Use JSON-RPC format
- Validate inputs before execution
- Return structured responses

## Logging
- Log all actions to Action Log
- Include tool name + payload

## Error Handling
- Retry once
- Return structured error

## Tools Priority
- ai_meta_generate
- ai_keyword_extract
- schema_generate
- link_suggest
- seo_audit_run